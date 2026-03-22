import { useState } from 'react';

const TYPE_ICONS = {
    total_score:                    { icon: '🏆', color: '#fef3c7', border: '#fcd34d' },
    victory_count:                  { icon: '⚔️', color: '#fce7f3', border: '#f9a8d4' },
    achievement_count:              { icon: '🎖️', color: '#ede9fe', border: '#c4b5fd' },
    category_deplacement:           { icon: '🚲', color: '#dbeafe', border: '#93c5fd' },
    category_alimentation:          { icon: '🥗', color: '#dcfce7', border: '#86efac' },
    category_energie:               { icon: '⚡', color: '#fef9c3', border: '#fde047' },
    category_numerique:             { icon: '💻', color: '#e0f2fe', border: '#7dd3fc' },
    category_consommation:          { icon: '🛍️', color: '#fce7f3', border: '#f9a8d4' },
    category_dechets:               { icon: '♻️', color: '#dcfce7', border: '#86efac' },
    category_engagement_ecologique: { icon: '🌿', color: '#d1fae5', border: '#6ee7b7' },
};

function BadgeImage({ imageUrl, name, meta }) {
    const [imgFailed, setImgFailed] = useState(false);
    const showImage = imageUrl && !imgFailed;

    return (
        <div className="recent-badge-icon-circle" style={{ background: meta.color, borderColor: meta.border }}>
            {showImage ? (
                <img
                    src={`/${imageUrl}`}
                    alt={name}
                    className="badge-img"
                    onError={() => setImgFailed(true)}
                />
            ) : (
                <span>{meta.icon}</span>
            )}
        </div>
    );
}

function NextBadgeCard({ nextBadge }) {
    if (!nextBadge) return null;
    const meta = TYPE_ICONS[nextBadge.type] ?? { icon: '🌱', color: '#dcfce7', border: '#86efac' };
    const label = nextBadge.name.replace(/^[^-]+ - /, '');

    return (
        <div className="next-badge-card">
            <p className="next-badge-title">Prochain Badge</p>
            <div className="next-badge-info">
                <BadgeImage imageUrl={nextBadge.imageUrl} name={label} meta={meta} />
                <p className="next-badge-name">{label}</p>
            </div>
            <div className="next-badge-progress">
                <div className="next-badge-progress-labels">
                    <span>{nextBadge.currentValue} pts</span>
                    <span>Objectif : {nextBadge.threshold} pts</span>
                </div>
                <div className="next-badge-bar-bg">
                    <div className="next-badge-bar-fill" style={{ width: `${nextBadge.progressPct}%` }} />
                </div>
                <p className="next-badge-pct">{nextBadge.progressPct}%</p>
            </div>
        </div>
    );
}

export default function RecentBadgesCard({ recentBadges, nextBadge, setActiveTab }) {
    if (!recentBadges || recentBadges.length === 0) return null;

    return (
        <div className="recent-badges-section">
            <div className="recent-badges-header">
                <h3 className="recent-badges-title">Derniers Badges</h3>
                <button className="recent-badges-voir-tout" onClick={() => setActiveTab('badges')}>
                    Voir tout
                </button>
            </div>

            <div className="recent-badges-content">
                <div className="recent-badges-row">
                    {recentBadges.map(badge => {
                        const meta = TYPE_ICONS[badge.type] ?? { icon: '🌱', color: '#dcfce7', border: '#86efac' };
                        return (
                            <div key={badge.code} className="recent-badge-card">
                                <BadgeImage imageUrl={badge.imageUrl} name={badge.name} meta={meta} />
                                <p className="recent-badge-name">{badge.name.replace(/^[^-]+ - /, '')}</p>
                            </div>
                        );
                    })}
                </div>

                <NextBadgeCard nextBadge={nextBadge} />
            </div>
        </div>
    );
}
