import { useState, useEffect } from 'react';
import { AlertCircle, CheckCircle, X } from 'lucide-react';

export default function MyChallengesTab() {
    const [challenges, setChallenges] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [toast, setToast] = useState(null);
    const [toastType, setToastType] = useState(null);
    const [registeredChallenges, setRegisteredChallenges] = useState(new Set());
    const [selectedChallenge, setSelectedChallenge] = useState(null);
    const [kmValues, setKmValues] = useState({});

    const showToast = (message, type = 'success') => {
        setToast(message);
        setToastType(type);
        setTimeout(() => {
            setToast(null);
        }, 3000);
    };

    useEffect(() => {
        const fetchChallenges = async () => {
            try {
                const response = await fetch('/api/challenges');
                if (!response.ok) {
                    throw new Error('Failed to fetch challenges');
                }
                const result = await response.json();
                if (result.status === 'ok') {
                    setChallenges(result.data);
                } else {
                    setError('Failed to load challenges');
                }
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchChallenges();
    }, []);

    const getActionsRequiringKm = (challenge) => {
        return challenge.actions.filter(action => action.inputType === 'km');
    };

    const handleChallengeClick = (challenge) => {
        const kmActions = getActionsRequiringKm(challenge);
        if (kmActions.length > 0) {
            setSelectedChallenge(challenge);
            setKmValues({});
        } else {
            registerChallenge(challenge, {});
        }
    };

    const handleKmInputChange = (actionId, value) => {
        setKmValues(prev => ({
            ...prev,
            [actionId]: value,
        }));
    };

    const handleKmSubmit = async () => {
        const challenge = selectedChallenge;
        const kmActions = getActionsRequiringKm(challenge);

        // Validate all km values are provided
        for (const action of kmActions) {
            if (!kmValues[action.id] || kmValues[action.id] <= 0) {
                showToast(`Veuillez entrer une valeur valide pour ${action.name}`, 'error');
                return;
            }
        }

        setSelectedChallenge(null);
        await registerChallenge(challenge, kmValues);
    };

    const registerChallenge = async (challenge, kmData) => {
        if (registeredChallenges.has(challenge.id)) {
            showToast('Défi déjà enregistré!', 'info');
            return;
        }

        try {
            // Register each action with appropriate km value if needed
            for (const action of challenge.actions) {
                const variant = challenge.variants.find(v => v.ecoActionId === action.id);

                if (!variant) continue;

                const payload = {
                    categoryId: challenge.categoryId,
                    ecoActionId: action.id,
                    ecoActionVariantId: variant.id,
                    km: action.inputType === 'km' ? Number(kmData[action.id] || 0) : null,
                };

                const response = await fetch('/user-action', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();
                if (result.status !== 'ok') {
                    showToast(`Erreur: ${result.message}`, 'error');
                    return;
                }
            }

            setRegisteredChallenges(new Set([...registeredChallenges, challenge.id]));
            showToast(`Défi "${challenge.title}" enregistré! 🎉`, 'success');
        } catch (error) {
            showToast('Erreur serveur', 'error');
        }
    };

    const getDifficultyColor = (difficulty) => {
        switch (difficulty) {
            case 'facile':
                return '#10b981';
            case 'moyen':
                return '#f59e0b';
            case 'difficile':
                return '#ef4444';
            default:
                return '#6b7280';
        }
    };

    const getDifficultyLabel = (difficulty) => {
        const labels = {
            facile: 'Facile',
            moyen: 'Moyen',
            difficile: 'Difficile',
        };
        return labels[difficulty] || difficulty;
    };

    if (loading) {
        return <div className="challenges-loading">Chargement des défis...</div>;
    }

    if (error) {
        return <div className="challenges-error">Erreur: {error}</div>;
    }

    // Group challenges by category
    const groupedChallenges = challenges.reduce((groups, challenge) => {
        const category = challenge.category;
        if (!groups[category]) {
            groups[category] = [];
        }
        groups[category].push(challenge);
        return groups;
    }, {});

    return (
        <div className="challenges-container">
            <div className="challenges-header">
                <h2>Mes Défis</h2>
                <p>Relevez des défis pour gagner des points et réduire votre empreinte carbone</p>
            </div>

            {Object.entries(groupedChallenges).map(([category, categoryChallenges]) => (
                <div key={category} className="challenges-category">
                    <h3 className="category-title">{category}</h3>
                    <div className="challenges-grid">
                        {categoryChallenges.map((challenge) => (
                            <div
                                key={challenge.id}
                                className={`challenge-card ${registeredChallenges.has(challenge.id) ? 'is-registered' : ''}`}
                            >
                                <div className="challenge-header">
                                    <h4>{challenge.title}</h4>
                                    <span
                                        className="difficulty-badge"
                                        style={{ backgroundColor: getDifficultyColor(challenge.difficulty) }}
                                    >
                                        {getDifficultyLabel(challenge.difficulty)}
                                    </span>
                                </div>

                                <p className="challenge-description">{challenge.description}</p>

                                <div className="challenge-actions">
                                    <h5>Actions incluses:</h5>
                                    <ul>
                                        {challenge.actions.map((action) => (
                                            <li key={action.id}>
                                                {action.name}
                                                {action.inputType === 'km' && <span className="km-badge">+ km</span>}
                                            </li>
                                        ))}
                                    </ul>
                                </div>

                                <button
                                    className="challenge-btn"
                                    onClick={() => handleChallengeClick(challenge)}
                                    disabled={registeredChallenges.has(challenge.id)}
                                >
                                    {registeredChallenges.has(challenge.id) ? (
                                        <>
                                            <CheckCircle size={18} />
                                            Enregistré
                                        </>
                                    ) : (
                                        'Relever le Défi'
                                    )}
                                </button>
                            </div>
                        ))}
                    </div>
                </div>
            ))}

            {/* Modal for km input */}
            {selectedChallenge && (
                <div className="challenge-modal-overlay">
                    <div className="challenge-modal">
                        <div className="challenge-modal-header">
                            <h3>Saisir les kilomètres</h3>
                            <button
                                className="challenge-modal-close"
                                onClick={() => setSelectedChallenge(null)}
                            >
                                <X size={24} />
                            </button>
                        </div>

                        <div className="challenge-modal-content">
                            <p>Veuillez entrer les kilomètres pour chaque action:</p>
                            {getActionsRequiringKm(selectedChallenge).map((action) => (
                                <div key={action.id} className="km-input-group">
                                    <label htmlFor={`km-${action.id}`}>{action.name}</label>
                                    <div className="km-input-wrapper">
                                        <input
                                            id={`km-${action.id}`}
                                            type="number"
                                            min="1"
                                            step="1"
                                            placeholder="Ex: 50"
                                            value={kmValues[action.id] || ''}
                                            onChange={(e) => handleKmInputChange(action.id, e.target.value)}
                                        />
                                        <span className="km-unit">km</span>
                                    </div>
                                </div>
                            ))}
                        </div>

                        <div className="challenge-modal-footer">
                            <button
                                className="challenge-modal-cancel"
                                onClick={() => setSelectedChallenge(null)}
                            >
                                Annuler
                            </button>
                            <button
                                className="challenge-modal-submit"
                                onClick={handleKmSubmit}
                            >
                                Valider
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {toast && (
                <div className={`challenge-toast ${toastType}`}>
                    {toast}
                </div>
            )}
        </div>
    );
}