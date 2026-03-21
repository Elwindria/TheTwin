import { useState, useMemo } from 'react';

const CATEGORY_ICONS = {
    'Déplacement':            '🚲',
    'Alimentation':           '🥗',
    'Énergie':                '⚡',
    'Energie':                '⚡',
    'Numérique':              '💻',
    'Numerique':              '💻',
    'Consommation':           '🛍️',
    'Déchets':                '♻️',
    'Dechets':                '♻️',
    'Engagement écologique':  '🌿',
};

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}

function formatCo2(grams) {
    if (grams >= 1000) return `${(grams / 1000).toFixed(2)} kg`;
    return `${Math.round(grams)} g`;
}

export default function MyScoreTab({ userActionsData = [] }) {
    const [search, setSearch]       = useState('');
    const [filterCategory, setCategory] = useState('');

    const scoreByCategory = useMemo(() => {
        const map = {};
        userActionsData.forEach(a => {
            if (!map[a.category]) map[a.category] = { score: 0, count: 0 };
            map[a.category].score += a.score;
            map[a.category].count += 1;
        });
        return Object.entries(map).sort((a, b) => b[1].score - a[1].score);
    }, [userActionsData]);

    const totalScore = useMemo(() =>
        userActionsData.reduce((sum, a) => sum + a.score, 0),
    [userActionsData]);

    const categories = useMemo(() => {
        return [...new Set(userActionsData.map(a => a.category))].sort();
    }, [userActionsData]);

    const filtered = useMemo(() => {
        return userActionsData.filter(a => {
            const matchSearch   = a.actionName.toLowerCase().includes(search.toLowerCase());
            const matchCategory = filterCategory ? a.category === filterCategory : true;
            return matchSearch && matchCategory;
        });
    }, [userActionsData, search, filterCategory]);

    if (userActionsData.length === 0) {
        return <p className="score-empty">Aucune action enregistrée pour le moment.</p>;
    }

    return (
        <div className="score-tab">

            <div className="score-total-card">
                <span className="score-total-label">Score total</span>
                <span className="score-total-value">{totalScore.toLocaleString()} pts</span>
            </div>

            <div className="score-categories-grid">
                {scoreByCategory.map(([cat, data]) => (
                    <div key={cat} className="score-category-card">
                        <span className="score-category-icon">
                            {CATEGORY_ICONS[cat] ?? '🌱'}
                        </span>
                        <span className="score-category-name">{cat}</span>
                        <span className="score-category-pts">{data.score.toLocaleString()} pts</span>
                        <span className="score-category-count">{data.count} action{data.count > 1 ? 's' : ''}</span>
                    </div>
                ))}
            </div>

            <div className="historique-filters">
                <input
                    type="text"
                    className="historique-search"
                    placeholder="Rechercher une action..."
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                />
                <select
                    className="historique-select"
                    value={filterCategory}
                    onChange={e => setCategory(e.target.value)}
                >
                    <option value="">Toutes les catégories</option>
                    {categories.map(cat => (
                        <option key={cat} value={cat}>{cat}</option>
                    ))}
                </select>
                <span className="historique-count">
                    {filtered.length} action{filtered.length !== 1 ? 's' : ''}
                </span>
            </div>

            {filtered.length === 0 ? (
                <p className="historique-empty">Aucune action trouvée.</p>
            ) : (
                <div className="historique-list">
                    {filtered.map((action, i) => (
                        <div key={i} className="historique-item">
                            <div className="historique-item__left">
                                <span className="historique-item__date">{formatDate(action.date)}</span>
                                <span className="historique-item__name">{action.actionName}</span>
                                <span className="historique-item__category">{action.category}</span>
                            </div>
                            <div className="historique-item__right">
                                <span className="historique-item__co2">
                                    🌿 {formatCo2(action.co2)}
                                </span>
                                <span className="historique-item__score">
                                    +{action.score} pts
                                </span>
                            </div>
                        </div>
                    ))}
                </div>
            )}

        </div>
    );
}
