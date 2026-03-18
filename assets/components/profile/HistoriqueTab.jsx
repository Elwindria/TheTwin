import { useState, useMemo } from 'react';

// affiche le CO2 en g ou en kg selon la valeur
function formatCo2(grams) {
    if (grams >= 1000) {
        return `${(grams / 1000).toFixed(2)} kg`;
    }
    return `${Math.round(grams)} g`;
}

// formate la date en "12 mars 2026"
function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}

export default function HistoriqueTab({ allActionsData }) {
    const [search, setSearch]           = useState('');
    const [filterCategory, setCategory] = useState('');

    // liste des catégories disponibles pour le filtre
    const categories = useMemo(() => {
        const unique = [...new Set(allActionsData.map(a => a.category))];
        return unique.sort();
    }, [allActionsData]);

    // filtrage par recherche et/ou catégorie
    const filtered = useMemo(() => {
        return allActionsData.filter(a => {
            const matchSearch   = a.actionName.toLowerCase().includes(search.toLowerCase());
            const matchCategory = filterCategory ? a.category === filterCategory : true;
            return matchSearch && matchCategory;
        });
    }, [allActionsData, search, filterCategory]);

    return (
        <div className="historique-tab">

            {/* Barre de filtres */}
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

            {/* Liste des actions */}
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