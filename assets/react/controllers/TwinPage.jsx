import { useState } from 'react';
import TwinTabs from '../../components/twin/TwinTabs';
import MyTwinTab from '../../components/twin/MyTwinTab';
import MyScoreTab from '../../components/twin/MyScoreTab';
import MyChallengesTab from '../../components/twin/MyChallengesTab';
import MyActionsTab from '../../components/twin/MyActionsTab';

export default function TwinPage() {
    const [activeTab, setActiveTab] = useState('twin');

    const renderActiveTab = () => {
        switch (activeTab) {
            case 'twin':
                return <MyTwinTab />;
            case 'score':
                return <MyScoreTab />;
            case 'challenges':
                return <MyChallengesTab />;
            case 'actions':
                return <MyActionsTab />;
            default:
                return <MyTwinTab />;
        }
    };

    return (
        <section className="twin-page">
            <TwinTabs activeTab={activeTab} setActiveTab={setActiveTab} />

            <div className="twin-page__content">
                {renderActiveTab()}
            </div>
        </section>
    );
}