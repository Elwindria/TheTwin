// Carte en haut de la page profil : avatar, nom, badges et bouton modifier
export default function ProfileHeader({ editUrl, firstName, lastName, username, avatarUrl }) {

    // On génère les initiales à partir du prénom et nom pour le placeholder
    const initials = `${firstName?.[0] ?? ''}${lastName?.[0] ?? ''}`.toUpperCase();

    return (
        <div className="profil-header-card">

            {/* Avatar avec bordure verte et badge LVL */}
            <div className="profil-avatar-wrapper">
                {avatarUrl ? (
                    <img
                        src={avatarUrl}
                        alt="Photo de profil"
                        className="profil-avatar"
                    />
                ) : (
                    // Pas de photo : on affiche les initiales
                    <div className="profil-avatar profil-avatar--placeholder">
                        {initials}
                    </div>
                )}
                <span className="profil-lvl-badge">LVL 1</span>
            </div>

            {/* Informations de l'utilisateur */}
            <div className="profil-info">
                <h2 className="profil-name">{firstName} {lastName}</h2>

                <div className="profil-badges-row">
                    <span className="profil-since">@{username}</span>
                </div>
            </div>

            {/* Bouton pour aller sur la page d'édition */}
            <a href={editUrl} className="profil-edit-btn">
                ✏ Modifier le profil
            </a>

        </div>
    );
}
