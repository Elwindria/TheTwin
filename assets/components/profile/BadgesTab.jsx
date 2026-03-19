import { useState } from 'react';

const TYPE_LABELS = {
    total_score:                    { label: 'Score total',    icon: '🏆' },
    victory_count:                  { label: 'Victoires',      icon: '⚔️' },
    achievement_count:              { label: 'Achievements',   icon: '🎖️' },
    category_deplacement:           { label: 'Déplacement',    icon: '🚲' },
    category_alimentation:          { label: 'Alimentation',   icon: '🥗' },
    category_energie:               { label: 'Énergie',        icon: '⚡' },
    category_numerique:             { label: 'Numérique',      icon: '💻' },
    category_consommation:          { label: 'Consommation',   icon: '🛍️' },
    category_dechets:               { label: 'Déchets',        icon: '♻️' },
    category_engagement_ecologique: { label: 'Engagement éco', icon: '🌿' },
};

function BadgeCard({ badge, fallbackIcon }) {
    const [imgFailed, setImgFailed] = useState(false);
    const showImage = badge.imageUrl && !imgFailed;

    return (
        <div className={`badge-card ${badge.unlocked ? 'badge-card--unlocked' : 'badge-card--locked'}`}>
            <div className="badge-icon-wrap">
                {showImage ? (
                    <img
                        src={`/${badge.imageUrl}`}
                        alt={badge.name}
                        className="badge-img"
                        onError={() => setImgFailed(true)}
                    />
                ) : (
                    <span className="badge-icon">
                        {badge.unlocked ? fallbackIcon : '🔒'}
                    </span>
                )}
            </div>
            <p className="badge-name">{badge.name.replace(/^[^-]+ - /, '')}</p>
            {badge.unlocked && (
                <span className="badge-unlocked-tag">Débloqué</span>
            )}
        </div>
    );
}

export default function BadgesTab({ achievementsData }) {
    const grouped = achievementsData.reduce((acc, badge) => {
        if (!acc[badge.type]) acc[badge.type] = [];
        acc[badge.type].push(badge);
        return acc;
    }, {});

    Object.values(grouped).forEach(badges =>
        badges.sort((a, b) => a.threshold - b.threshold)
    );

    const unlockedCount = achievementsData.filter(b => b.unlocked).length;
    const total = achievementsData.length;
    const progressPct = Math.round((unlockedCount / total) * 100);

    return (
        <div className="badges-tab">

            <div className="badges-progress-card">
                <div className="badges-progress-header">
                    <span className="badges-progress-label">Progression globale</span>
                    <span className="badges-progress-count">{unlockedCount} / {total}</span>
                </div>
                <div className="badges-progress-bar-bg">
                    <div className="badges-progress-bar-fill" style={{ width: `${progressPct}%` }} />
                </div>
            </div>

            {Object.entries(grouped).map(([type, badges]) => {
                const meta = TYPE_LABELS[type] ?? { label: type, icon: '🌱' };
                const unlockedInGroup = badges.filter(b => b.unlocked).length;

                return (
                    <div key={type} className="badges-group">
                        <div className="badges-group-header">
                            <h3 className="badges-group-title">
                                <span>{meta.icon}</span> {meta.label}
                            </h3>
                            <span className="badges-group-count">{unlockedInGroup}/{badges.length}</span>
                        </div>

                        <div className="badges-grid">
                            {badges.map(badge => (
                                <BadgeCard key={badge.code} badge={badge} fallbackIcon={meta.icon} />
                            ))}
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
