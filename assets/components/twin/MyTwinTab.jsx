import { Apple, Bike, Computer, House, Leaf, ShoppingBag, Trash2, Zap } from 'lucide-react';
import { useState, useEffect } from 'react';

export default function MyTwinTab() {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchTwinCarbonData = async () => {
            try {
                const response = await fetch('/api/twin/carbon-by-category');
                if (!response.ok) {
                    throw new Error('Failed to fetch twin carbon data');
                }
                const result = await response.json();
                if (result.status === 'ok') {
                    setData(result);
                } else {
                    setError('Failed to load data');
                }
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchTwinCarbonData();
    }, []);

    if (loading) {
        return <div className="twin-tab-loading">Chargement...</div>;
    }

    if (error) {
        return <div className="twin-tab-error">Erreur: {error}</div>;
    }

    if (!data || !data.data || data.data.length === 0) {
        return (
            <div className="twin-tab-empty">
                <h2>Status du Carbon Twin</h2>
                <p>Aucune donnée disponible pour le moment.</p>
            </div>
        );
    }

    const categoryIcons = {
        'Déplacement': <Bike />,
        'Alimentation': <Apple />,
        'Logement': <House />,
        'Consommation': <ShoppingBag />,
        'Energie': <Zap />,
        'Numérique': <Computer />,
        'Déchets': <Trash2 />,
        'Engagement écologique': <Leaf />,
    };

    return (
        <div className="twin-status-container">
            <div className="twin-status-header">
                <h2>Status du Carbon Twin</h2>
                <p>Votre empreinte carbone en temps réel</p>
            </div>

            <div className="twin-status-summary">
                <div className="twin-total-co2">
                    <div className="total-label">Empreinte Carbone Totale</div>
                    <div className="total-value">{data.total} t CO₂e</div>
                </div>
            </div>

            <div className="twin-categories-grid">
                {data.data.map((item) => (
                    <div key={item.category} className="category-card">
                        <div className="category-icon" style={{ color: '#3cb16f' }}>
                            {categoryIcons[item.category]}
                        </div>
                        <div className="category-name">{item.category}</div>
                        <div className="category-co2">{item.co2} <span>t</span></div>
                    </div>
                ))}
            </div>
        </div>
    );
}
