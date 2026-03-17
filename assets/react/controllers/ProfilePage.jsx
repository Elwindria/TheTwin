import ProfileHeader from '../../components/profile/ProfileHeader';

// Composant principal de la page profil
// Il reçoit les données utilisateur en props depuis le controller Symfony
export default function ProfilePage({ editUrl, firstName, lastName, username, avatarUrl }) {
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

        </div>
    );
}
