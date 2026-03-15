import { useState } from 'react';
import TwinTabs from '../../components/twin/TwinTabs';
import MyTwinTab from '../../components/twin/MyTwinTab';
import MyScoreTab from '../../components/twin/MyScoreTab';
import MyChallengesTab from '../../components/twin/MyChallengesTab';
import MyActionsTab from '../../components/twin/MyActionsTab';
import twinImage from '../../images/twin.png';
import natureImage from '../../images/natureImage.png';

export default function TwinPage({ actionsData }) {
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
                return <MyActionsTab actionsData={actionsData} />;
            default:
                return <MyTwinTab />;
        }
    };

    const getTwinImage = () => {
        switch (activeTab) {
            case 'twin':
                return twinImage;
            case 'score':
                return natureImage;
            case 'challenges':
                return natureImage;
            case 'actions':
                return natureImage;
            default:
                return twinImage;
        }
    };

    const getTwinImageClass = () => {
        switch (activeTab) {
            case 'twin':
                return "img-twin";
            case 'score':
                return "img-nature";
            case 'challenges':
                return "img-nature";
            case 'actions':
                return "img-nature";
            default:
                return "img-nature";
        }
    };

    return (
        <section className="twin-page" id="twin-page">
            <div id="twin-page-left" className="twin-panel">
                <img className={getTwinImageClass()} src={getTwinImage()} alt="Twin" />
            </div>
            <div id="twin-page-right" className="twin-panel">
                <TwinTabs activeTab={activeTab} setActiveTab={setActiveTab} />

                <div className="twin-page__content">
                    {renderActiveTab()}
                </div>
            </div>
        </section>
    );
}