
import { useMemo, useState } from 'react';

export default function MyActionsTab({ actionsData }) {
    const [selectedCategoryId, setSelectedCategoryId] = useState('');
    const [selectedActionId, setSelectedActionId] = useState('');
    const [selectedVariantId, setSelectedVariantId] = useState('');
    const [kmValue, setKmValue] = useState('');
    const [toast, setToast] = useState(null);
    const [toastType, setToastType] = useState(null);

    const showToast = (message, type = "success") => {
        setToast(message);
        setToastType(type);

        setTimeout(() => {
            setToast(null);
        }, 4000);
    };

    const selectedCategory = useMemo(() => {
        return actionsData.find(
            (category) => String(category.id) === String(selectedCategoryId)
        );
    }, [actionsData, selectedCategoryId]);

    const selectedAction = useMemo(() => {
        if (!selectedCategory) {
            return null;
        }

        return selectedCategory.actions.find(
            (action) => String(action.id) === String(selectedActionId)
        );
    }, [selectedCategory, selectedActionId]);

    const selectedVariant = useMemo(() => {
        if (!selectedAction) {
            return null;
        }

        return selectedAction.variants.find(
            (variant) => String(variant.id) === String(selectedVariantId)
        );
    }, [selectedAction, selectedVariantId]);

    const handleCategoryChange = (event) => {
        const newCategoryId = event.target.value;

        setSelectedCategoryId(newCategoryId);
        setSelectedActionId('');
        setSelectedVariantId('');
        setKmValue('');
    };

    const handleActionChange = (event) => {
        const newActionId = event.target.value;

        setSelectedActionId(newActionId);
        setSelectedVariantId('');
        setKmValue('');
    };

    const handleVariantChange = (event) => {
        setSelectedVariantId(event.target.value);
    };

    const handleSubmit = async (event) => {
        event.preventDefault();

        if (!selectedCategory || !selectedAction || !selectedVariant) {
            return;
        }

        if (selectedAction.inputType === 'km' && !kmValue) {
            return;
        }

        const payload = {
            categoryId: selectedCategory.id,
            ecoActionId: selectedAction.id,
            ecoActionVariantId: selectedVariant.id,
            km: selectedAction.inputType === 'km' ? Number(kmValue) : null,
        };

        try {
            const response = await fetch('/user-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const result = await response.json();

            if (result.status === "ok") {
                showToast(result.message, "success");

                setSelectedCategoryId('');
                setSelectedActionId('');
                setSelectedVariantId('');
                setKmValue('');
            } else {
                showToast(result.message, "error");
            }
        } catch (error) {
            showToast("Erreur serveur", "error");
        }
    };

    return (
        <div id="form-actions">
            <h2>Mes Actions</h2>

            <form onSubmit={handleSubmit}>
                <div className="div-form-actions">
                    <label htmlFor="category">Catégorie :</label>
                    <select
                        id="category"
                        value={selectedCategoryId}
                        onChange={handleCategoryChange}
                    >
                        <option value="">Choisir une catégorie</option>
                        {actionsData.map((category) => (
                            <option key={category.id} value={category.id}>
                                {category.name}
                            </option>
                        ))}
                    </select>
                </div>

                {selectedCategory && (
                    <div className="div-form-actions">
                        <label htmlFor="action">Action :</label>
                        <select
                            id="action"
                            value={selectedActionId}
                            onChange={handleActionChange}
                        >
                            <option value="">Choisir une action</option>
                            {selectedCategory.actions.map((action) => (
                                <option key={action.id} value={action.id}>
                                    {action.name}
                                </option>
                            ))}
                        </select>
                    </div>
                )}

                {selectedAction && (
                    <div className="div-form-actions">
                        <label htmlFor="variant">Variante :</label>
                        <select
                            id="variant"
                            value={selectedVariantId}
                            onChange={handleVariantChange}
                        >
                            <option value="">Choisir une variante</option>
                            {selectedAction.variants.map((variant) => (
                                <option key={variant.id} value={variant.id}>
                                    {variant.name}
                                </option>
                            ))}
                        </select>
                    </div>
                )}

                {selectedAction && selectedAction.inputType === 'km' && (
                    <div className="div-form-actions">
                        <label htmlFor="km">Nombre de kilomètres :</label>
                        <input
                            id="km"
                            type="number"
                            min="1"
                            step="1"
                            value={kmValue}
                            onChange={(event) => setKmValue(event.target.value)}
                            placeholder="Ex : 12"
                        />
                    </div>
                )}

                {selectedVariant && (
                    <button type="submit">
                        Ajouter l’action
                    </button>
                )}

                {toast && (
                    <div className="toast-container">
                        <div className={`toast ${toastType} show`}>
                            {toast}
                        </div>
                    </div>
                )}
            </form>
        </div>
    );
}