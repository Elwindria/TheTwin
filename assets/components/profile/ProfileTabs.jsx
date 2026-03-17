const TABS = [
    { key: 'overview',  label: "Vue d'ensemble" },
    { key: 'badges',    label: 'Mes Badges' },
    { key: 'co2',       label: 'Économies CO2' },
    { key: 'history',   label: 'Historique' },
    { key: 'settings',  label: 'Paramètres' },
];

export default function ProfileTabs({ activeTab, setActiveTab }) {
    return (
        <div className="profil-tabs">
            {TABS.map(tab => (
                <button
                    key={tab.key}
                    className={`profil-tab ${activeTab === tab.key ? 'profil-tab--active' : ''}`}
                    onClick={() => setActiveTab(tab.key)}
                >
                    {tab.label}
                </button>
            ))}
        </div>
    );
}
