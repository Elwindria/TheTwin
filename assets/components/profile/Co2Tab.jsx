import { useState, useMemo } from 'react';
import {
    LineChart, Line, BarChart, Bar,
    XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer
} from 'recharts';

// on formate une date YYYY-MM-DD pour l'affichage dans les inputs
function today() {
    return new Date().toISOString().slice(0, 10);
}

// date il y a 6 mois
function sixMonthsAgo() {
    const d = new Date();
    d.setMonth(d.getMonth() - 6);
    return d.toISOString().slice(0, 10);
}

// regroupe les actions filtrées par mois pour le LineChart
// on génère tous les mois de la période (même ceux à 0) pour avoir une ligne continue
function buildMonthlyCo2(actions, startDate, endDate) {
    // d'abord on accumule le CO2 par mois
    const totals = {};
    actions.forEach(({ date, co2 }) => {
        const d   = new Date(date);
        const key = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
        totals[key] = (totals[key] ?? 0) + co2;
    });

    // ensuite on crée un point pour chaque mois de la plage sélectionnée
    const result = [];
    const start  = new Date(startDate);
    const end    = new Date(endDate);
    const cursor = new Date(start.getFullYear(), start.getMonth(), 1);

    while (cursor <= end) {
        const key   = `${cursor.getFullYear()}-${String(cursor.getMonth() + 1).padStart(2, '0')}`;
        const label = cursor.toLocaleString('fr-FR', { month: 'short', year: '2-digit' });
        result.push({
            month: label,
            co2: Math.round((totals[key] ?? 0) / 1000 * 100) / 100,
        });
        cursor.setMonth(cursor.getMonth() + 1);
    }
    return result;
}

// regroupe par catégorie pour le BarChart
function buildCategoryData(actions) {
    const grouped = {};
    actions.forEach(({ category, co2 }) => {
        grouped[category] = (grouped[category] ?? 0) + co2;
    });
    return Object.entries(grouped).map(([category, co2]) => ({
        category,
        co2: Math.round(co2 / 1000 * 100) / 100,
    }));
}

export default function Co2Tab({ monthlyCo2, co2ByCategoryData, allActionsData }) {
    // par défaut : les 6 derniers mois
    const [startDate, setStartDate] = useState(sixMonthsAgo());
    const [endDate, setEndDate]     = useState(today());

    // on filtre les actions selon la période choisie
    const filtered = useMemo(() => {
        if (!allActionsData?.length) return [];
        return allActionsData.filter(({ date }) => date >= startDate && date <= endDate);
    }, [allActionsData, startDate, endDate]);

    // si un filtre est actif on recalcule, sinon on utilise les données PHP
    const hasFilter = allActionsData?.length > 0;
    const lineData  = hasFilter ? buildMonthlyCo2(filtered, startDate, endDate) : monthlyCo2;
    const barData   = hasFilter ? buildCategoryData(filtered) : co2ByCategoryData;

    const totalFiltered = filtered.reduce((acc, { co2 }) => acc + co2, 0);
    const displayTotal  = totalFiltered >= 1000
        ? `${(totalFiltered / 1000).toFixed(2)} kg`
        : `${Math.round(totalFiltered)} g`;

    return (
        <div className="co2-tab">

            {/* --- Filtre par période --- */}
            <div className="co2-filter">
                <span className="co2-filter__label">Période :</span>
                <input
                    type="date"
                    className="co2-filter__input"
                    value={startDate}
                    max={endDate}
                    onChange={e => setStartDate(e.target.value)}
                />
                <span className="co2-filter__sep">→</span>
                <input
                    type="date"
                    className="co2-filter__input"
                    value={endDate}
                    min={startDate}
                    max={today()}
                    onChange={e => setEndDate(e.target.value)}
                />
                {hasFilter && (
                    <span className="co2-filter__total">
                        Total : <strong>{displayTotal}</strong>
                    </span>
                )}
            </div>

            {/* --- LineChart --- */}
            <div className="co2-section">
                <h3 className="co2-section__title">Évolution sur la période (kg)</h3>
                <div className="co2-chart-wrapper">
                    {lineData.length === 0 ? (
                        <p className="co2-empty">Aucune action sur cette période.</p>
                    ) : (
                        <ResponsiveContainer width="100%" height={220}>
                            <LineChart data={lineData}>
                                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                                <XAxis dataKey="month" tick={{ fontSize: 12, fill: '#888' }} />
                                <YAxis tick={{ fontSize: 12, fill: '#888' }} />
                                <Tooltip
                                    formatter={(value) => [`${value} kg`, 'CO2 économisé']}
                                    contentStyle={{ borderRadius: '8px', border: '1px solid #e0e0e0' }}
                                />
                                <Line
                                    type="monotone"
                                    dataKey="co2"
                                    stroke="#3cb16f"
                                    strokeWidth={2}
                                    dot={{ fill: '#3cb16f', r: 4 }}
                                    activeDot={{ r: 6 }}
                                />
                            </LineChart>
                        </ResponsiveContainer>
                    )}
                </div>
            </div>

            {/* --- BarChart --- */}
            <div className="co2-section">
                <h3 className="co2-section__title">Par catégorie (kg)</h3>
                <div className="co2-chart-wrapper">
                    {barData.length === 0 ? (
                        <p className="co2-empty">Aucune action sur cette période.</p>
                    ) : (
                        <ResponsiveContainer width="100%" height={220}>
                            <BarChart data={barData}>
                                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                                <XAxis dataKey="category" tick={{ fontSize: 12, fill: '#888' }} />
                                <YAxis tick={{ fontSize: 12, fill: '#888' }} />
                                <Tooltip
                                    formatter={(value) => [`${value} kg`, 'CO2 économisé']}
                                    contentStyle={{ borderRadius: '8px', border: '1px solid #e0e0e0' }}
                                />
                                <Bar dataKey="co2" fill="#3cb16f" radius={[6, 6, 0, 0]} />
                            </BarChart>
                        </ResponsiveContainer>
                    )}
                </div>
            </div>

        </div>
    );
}