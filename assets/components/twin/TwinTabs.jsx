export default function TwinTabs({ activeTab, setActiveTab }) {
    const tabs = [
        { key: 'twin', label: 'MonTwin' },
        { key: 'score', label: 'Mon Score' },
        { key: 'challenges', label: 'Mes Défis' },
        { key: 'actions', label: 'Mes Actions' },
    ];

    return (
        <nav className="twin-tabs">
            {tabs.map((tab) => (
                <button
                    key={tab.key}
                    type="button"
                    className={`twin-tabs__button ${activeTab === tab.key ? 'is-active' : ''}`}
                    onClick={() => setActiveTab(tab.key)}
                >
                    {tab.label}
                </button>
            ))}
        </nav>
    );
}