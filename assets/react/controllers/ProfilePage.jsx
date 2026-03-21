import { useState } from 'react';
import ProfileHeader from '../../components/profile/ProfileHeader';
import ProfileTabs from '../../components/profile/ProfileTabs';
import StatsOverview from '../../components/profile/StatsOverview';
import MonthlyGoalCard from '../../components/profile/MonthlyGoalCard';
import Co2Tab from '../../components/profile/Co2Tab';
import HistoriqueTab from '../../components/profile/HistoriqueTab';
import BadgesTab from '../../components/profile/BadgesTab';
import RecentBadgesCard from '../../components/profile/RecentBadgesCard';

export default function ProfilePage({ editUrl, firstName, lastName, username, avatarUrl, totalCo2, twinCo2, scoreThisWeek, scoreWeekChange, totalActions, currentRank, co2Trend, actionsTrend, rankChange, co2ThisMonth, monthlyGoalCo2, monthlyCo2, co2ByCategoryData, allActionsData, achievementsData, recentBadges, nextBadge }) {
    const [activeTab, setActiveTab] = useState('overview');

    const renderTab = () => {
        switch (activeTab) {
            case 'overview':
                return (
                    <>
                        <StatsOverview
                            totalCo2={totalCo2}
                            twinCo2={twinCo2}
                            scoreThisWeek={scoreThisWeek}
                            scoreWeekChange={scoreWeekChange}
                            totalActions={totalActions}
                            currentRank={currentRank}
                            co2Trend={co2Trend}
                            actionsTrend={actionsTrend}
                            rankChange={rankChange}
                        />
                        <RecentBadgesCard recentBadges={recentBadges} nextBadge={nextBadge} setActiveTab={setActiveTab} />
                        <MonthlyGoalCard
                            co2ThisMonth={co2ThisMonth}
                            monthlyGoalCo2={monthlyGoalCo2}
                        />
                    </>
                );
            case 'co2':
                return (
                    <Co2Tab
                        monthlyCo2={monthlyCo2}
                        co2ByCategoryData={co2ByCategoryData}
                        allActionsData={allActionsData}
                    />
                );
            case 'badges':
                return <BadgesTab achievementsData={achievementsData} />;
            case 'history':
                return <HistoriqueTab allActionsData={allActionsData} />;
            default:
                return <p className="profil-tab-placeholder">Bientôt disponible</p>;
        }
    };

    return (
        <div className="profil-page">

            <div className="profil-hero">
                <h1 className="profil-title">MON PROFIL</h1>
                <p className="profil-subtitle">Suivez votre impact positif sur la planète et visualisez vos progrès.</p>
            </div>

            <ProfileHeader
                editUrl={editUrl}
                firstName={firstName}
                lastName={lastName}
                username={username}
                avatarUrl={avatarUrl}
            />

            <ProfileTabs activeTab={activeTab} setActiveTab={setActiveTab} />

            <div className="profil-tab-content">
                {renderTab()}
            </div>

        </div>
    );
}
