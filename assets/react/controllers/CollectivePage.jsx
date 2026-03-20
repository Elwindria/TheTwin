import { useState } from 'react';
import collectifImage from '../../images/collectifImage.png';
import iconDeplacement from '../../images/icon-deplacement.png';
import iconAlimentation from '../../images/icon-alimentation.png';
import iconNumerique from '../../images/icon-numerique.png';
import iconConsommation from '../../images/icon-consommation.png';
import iconDefault from '../../images/icon-default.png';

// Utilitaire : temps relatif
function timeAgo(dateString) {
    const now = new Date();
    const date = new Date(dateString);
    const diffMs = now - date;
    const diffMin = Math.floor(diffMs / 60000);

    if (diffMin < 1) return "À l'instant";
    if (diffMin < 60) return `Il y a ${diffMin} minute${diffMin > 1 ? 's' : ''}`;
    const diffH = Math.floor(diffMin / 60);
    if (diffH < 24) return `Il y a ${diffH} heure${diffH > 1 ? 's' : ''}`;
    const diffD = Math.floor(diffH / 24);
    return `Il y a ${diffD} jour${diffD > 1 ? 's' : ''}`;
}

// Icône catégorie
function CategoryIcon({ category }) {
    const icons = {
        'Déplacement':  iconDeplacement,
        'Alimentation': iconAlimentation,
        'Numérique':    iconNumerique,
        'Consommation': iconConsommation,
    };
    const icon = icons[category] ?? iconDefault;
    return (
        <div className="collective-action__icon">
           <img src={icon} alt={category} width="32" height="32" />
        </div>
    );
}

// Barre de progression
function ProgressBar({ value, max, color = '#3CB16F' }) {
    const pct = max > 0 ? Math.min(100, Math.round((value / max) * 100)) : 0;
    return (
        <div className="collective-progress">
            <div
                className="collective-progress__fill"
                style={{ width: `${pct}%`, backgroundColor: color }}
            />
        </div>
    );
}

// Carte stat
function StatCard({ label, value, unit, sub, accent }) {
    return (
        <div className="collective-stat-card">
            <span className="collective-stat-card__label">{label}</span>
            <span
                className="collective-stat-card__value"
                style={accent ? { color: accent } : {}}
            >
                {value}
                {unit && <span className="collective-stat-card__unit"> {unit}</span>}
            </span>
            {sub && <span className="collective-stat-card__sub">{sub}</span>}
        </div>
    );
}

// Composant principal
export default function CollectivePage({
    totalScore = 0,
    totalCo2Saved = 0,
    // totalTwinCo2 = 0,
    totalActionsCount = 0,
    weeklyScore = 0,
    weeklyGoal = 1000,
    weeklyDifficulty = 'normal',
    activeUsersCount = 0,
    recentActions = [],
}) {
    // Objectif hebdo fictif pour la barre de progression (à brancher plus tard)
    const progressPct = weeklyGoal > 0
        ? Math.min(100, Math.round((weeklyScore / weeklyGoal) * 100))
        : 0;

    // const co2Diff = (totalTwinCo2 - totalCo2Saved).toFixed(2);

    return (
        <section className="collective-page">

            {/* ── PANNEAU GAUCHE ── */}
            <div className="collective-panel collective-panel--left">
                <img
                    src={collectifImage}
                    alt="Espace collectif"
                    className="collective-panel__img"
                />
                <div className="collective-panel__overlay">
                    <h1 className="collective-panel__title">Espace Collectif</h1>
                    <p className="collective-panel__sub">
                        Ensemble, battez vos Twins.
                    </p>
                </div>
            </div>

            {/* ── PANNEAU DROIT ── */}
            <div className="collective-panel collective-panel--right">

                {/* En-tête */}
                <div className="collective-header">
                    <h2 className="collective-header__title">Tableau de bord</h2>
                    <span className="collective-header__badge">
                        {activeUsersCount} membre{activeUsersCount > 1 ? 's' : ''} actif{activeUsersCount > 1 ? 's' : ''}
                    </span>
                </div>

                {/* Stats */}
                <div className="collective-stats">
                    <StatCard
                        label="Score collectif"
                        value={totalScore.toLocaleString('fr-FR')}
                        unit="pts"
                        accent="#3CB16F"
                    />
                    <StatCard
                        label="CO₂ économisé"
                        value={totalCo2Saved.toLocaleString('fr-FR')}
                        unit="kg"
                        sub="vs les Twins"
                        accent="#3CB16F"
                    />
                    <StatCard
                        label="Actions réalisées"
                        value={totalActionsCount.toLocaleString('fr-FR')}
                        unit=""
                        sub="par le collectif"
                        accent="#3CB16F"
                    />
                </div>

                {/* Défi de la semaine */}
                <div className="collective-card">
                    <div className="collective-card__header">
                        <span className="collective-card__title">Défi de la semaine</span>
                        <span className={`collective-card__badge ${
                            weeklyDifficulty === 'facile' ? 'collective-card__badge--green' :
                            weeklyDifficulty === 'difficile' ? 'collective-card__badge--red' :
                            'collective-card__badge--orange'
                        }`}>
                            {weeklyDifficulty}
                        </span>
                    </div>
                    <p className="collective-card__hint">
                        Objectif collectif : atteindre {weeklyGoal.toLocaleString('fr-FR')} pts cette semaine.
                        {progressPct >= 100 && <strong> 🏆 Objectif atteint !</strong>}
                    </p>
                </div>

                {/* Progression hebdomadaire */}
                <div className="collective-card">
                    <div className="collective-card__header">
                        <span className="collective-card__title">Progression cette semaine</span>
                        <span className="collective-card__badge collective-card__badge--green">
                            {progressPct}%
                        </span>
                    </div>
                    <ProgressBar value={weeklyScore} max={weeklyGoal} />
                    <p className="collective-card__hint">
                        {weeklyScore.toLocaleString('fr-FR')} / {weeklyGoal.toLocaleString('fr-FR')} pts pour battre les Twins
                    </p>
                </div>

                {/* Dernières actions */}
                <div className="collective-card">
                    <div className="collective-card__header">
                        <span className="collective-card__title">Dernières actions</span>
                    </div>

                    {recentActions.length === 0 ? (
                        <p className="collective-empty">
                            Aucune action pour l'instant — soyez le premier !
                        </p>
                    ) : (
                        <ul className="collective-actions-list">
                            {recentActions.map((action, index) => (
                                <li key={index} className="collective-action">
                                    <CategoryIcon category={action.category} />
                                    <div className="collective-action__body">
                                        <p className="collective-action__text">
                                            <strong>{action.username}</strong> — {action.action}
                                        </p>
                                        <p className="collective-action__meta">
                                            {timeAgo(action.createdAt)}
                                            &nbsp;·&nbsp;
                                            {action.co2Saved} kg CO₂ économisés
                                        </p>
                                    </div>
                                    <span className="collective-action__score">
                                        +{action.score}p
                                    </span>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>

            </div>
        </section>
    );
}
