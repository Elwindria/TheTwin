import React, { useState } from 'react';
import MyTwinTab from './MyTwinTab';
import MyScoreTab from './MyScoreTab';
import MyChallengesTab from './MyChallengesTab';
import MyActionsTab from './MyActionsTab';

export default function TwinPage() {
    const [activeTab, setActiveTab] = useState('twin');

    return (
        <div>
            <nav>
                <button onClick={() => setActiveTab('twin')}>MonTwin</button>
                <button onClick={() => setActiveTab('score')}>Mon Score</button>
                <button onClick={() => setActiveTab('challenges')}>Mes Défis</button>
                <button onClick={() => setActiveTab('actions')}>Mes Actions</button>
            </nav>

            <div>
                {activeTab === 'twin' && <MyTwinTab />}
                {activeTab === 'score' && <MyScoreTab />}
                {activeTab === 'challenges' && <MyChallengesTab />}
                {activeTab === 'actions' && <MyActionsTab />}
            </div>
        </div>
    );
}