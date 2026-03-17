// les 3 cartes de stats : CO2, actions, classement
export default function StatsOverview({ totalCo2, totalActions, currentRank, co2Trend, actionsTrend, rankChange }) {

    // grammes si < 1000, sinon on convertit en kg
    const formatCo2 = (grams) => {
        if (grams < 1000) return { value: grams, unit: 'g' };
        return { value: (grams / 1000).toFixed(2).replace('.', ','), unit: 'kg' };
    };

    const formatTrend = (trend) => {
        if (trend === null || trend === undefined) return null;
        return `${trend >= 0 ? '+' : ''}${trend}%`;
    };

    const formatRankChange = (change) => {
        if (!change) return null;
        return change > 0 ? `+${change} places` : `${change} places`;
    };

    const co2 = formatCo2(totalCo2);

    return (
        <div className="stats-grid">

            <div className="stats-card">
                <div className="stats-icon stats-icon--green">CO₂</div>
                <p className="stats-label">CO2 Économisé</p>
                <p className="stats-value">
                    {co2.value} <span className="stats-unit">{co2.unit}</span>
                </p>
                {formatTrend(co2Trend) && (
                    <p className={`stats-trend ${co2Trend >= 0 ? 'trend--up' : 'trend--down'}`}>
                        {co2Trend >= 0 ? '↑' : '↓'} {formatTrend(co2Trend)} ce mois
                    </p>
                )}
            </div>

            <div className="stats-card">
                <div className="stats-icon stats-icon--yellow">✓</div>
                <p className="stats-label">Actions Complétées</p>
                <p className="stats-value">{totalActions}</p>
                {formatTrend(actionsTrend) && (
                    <p className={`stats-trend ${actionsTrend >= 0 ? 'trend--up' : 'trend--down'}`}>
                        {actionsTrend >= 0 ? '↑' : '↓'} {formatTrend(actionsTrend)} global
                    </p>
                )}
            </div>

            <div className="stats-card">
                <div className="stats-icon stats-icon--purple">#</div>
                <p className="stats-label">Classement Global</p>
                <p className="stats-value">#{currentRank}</p>
                {formatRankChange(rankChange) && (
                    <p className={`stats-trend ${rankChange > 0 ? 'trend--up' : 'trend--down'}`}>
                        {rankChange > 0 ? '↑' : '↓'} {formatRankChange(rankChange)}
                    </p>
                )}
            </div>

        </div>
    );
}
