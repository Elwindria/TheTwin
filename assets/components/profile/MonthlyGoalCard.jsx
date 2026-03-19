import { useState } from 'react';

// phrases de motivation selon la progression
function getMotivation(percent) {
    if (percent >= 100) return "Objectif atteint ce mois-ci, super boulot !";
    if (percent >= 75)  return "Encore un petit effort, tu y es presque !";
    if (percent >= 50)  return "Plus de la moitié faite, garde le rythme !";
    if (percent >= 25)  return "Bon début, continue sur cette lancée !";
    return "Lance-toi ! Chaque petite action compte.";
}

export default function MonthlyGoalCard({ co2ThisMonth, monthlyGoalCo2 }) {
    // goal en grammes, on affiche en kg
    const [goal, setGoal]         = useState(monthlyGoalCo2 ?? 10000); // default 10 kg
    const [editing, setEditing]   = useState(false);
    const [inputVal, setInputVal] = useState('');
    const [saving, setSaving]     = useState(false);

    const co2Kg   = co2ThisMonth / 1000;
    const goalKg  = goal / 1000;
    const percent = Math.min(Math.round((co2Kg / goalKg) * 100), 100);

    const startEdit = () => {
        setInputVal(goalKg);
        setEditing(true);
    };

    const saveGoal = async () => {
        const newGoalKg = parseFloat(inputVal);
        if (isNaN(newGoalKg) || newGoalKg <= 0) return;

        const newGoalGrams = Math.round(newGoalKg * 1000);
        setSaving(true);

        try {
            await fetch('/profile/goal', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ goal: newGoalGrams }),
            });
            setGoal(newGoalGrams);
            setEditing(false);
        } finally {
            setSaving(false);
        }
    };

    return (
        <div className="monthly-goal-card">

            <div className="monthly-goal-card__header">
                {editing ? (
                    <div className="monthly-goal-card__edit-row">
                        <span className="monthly-goal-card__title">Objectif Mensuel :</span>
                        <input
                            className="monthly-goal-card__input"
                            type="number"
                            min="0.1"
                            step="0.5"
                            value={inputVal}
                            onChange={e => setInputVal(e.target.value)}
                            autoFocus
                        />
                        <span className="monthly-goal-card__title">kg CO2</span>
                        <button className="monthly-goal-card__btn-save" onClick={saveGoal} disabled={saving}>
                            {saving ? '...' : 'OK'}
                        </button>
                        <button className="monthly-goal-card__btn-cancel" onClick={() => setEditing(false)}>
                            Annuler
                        </button>
                    </div>
                ) : (
                    <>
                        <h3 className="monthly-goal-card__title">
                            Objectif Mensuel : -{goalKg % 1 === 0 ? goalKg : goalKg.toFixed(1)}kg CO2
                        </h3>
                        <button className="monthly-goal-card__btn-edit" onClick={startEdit}>
                            ✏ Modifier
                        </button>
                    </>
                )}
            </div>

            {/* barre de progression */}
            <div className="monthly-goal-card__bar-track">
                <div
                    className="monthly-goal-card__bar-fill"
                    style={{ width: `${percent}%` }}
                />
            </div>

            {/* légende sous la barre */}
            <div className="monthly-goal-card__legend">
                <span>{co2Kg % 1 === 0 ? co2Kg : co2Kg.toFixed(2)}kg économisés</span>
                <span className="monthly-goal-card__percent">{percent}%</span>
                <span>Objectif : {goalKg % 1 === 0 ? goalKg : goalKg.toFixed(1)}kg</span>
            </div>

            {/* phrase de motivation */}
            <div className="monthly-goal-card__tip">
                <span className="monthly-goal-card__tip-icon">💡</span>
                <p>{getMotivation(percent)}</p>
            </div>

        </div>
    );
}
