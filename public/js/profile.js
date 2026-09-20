.profile-page {
    min-height: 100vh;
    background: #f8fafc;
    padding: 32px 0 60px;
    color: #0f172a;
    font-family: 'Inter', sans-serif;
}

.profile-container {
    width: min(1200px, calc(100% - 40px));
    margin: auto;
}

.profile-header {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 18px rgba(15, 23, 42, .06);
    margin-bottom: 24px;
}

.profile-info {
    padding: 28px 32px 0;
}

.profile-user {
    display: flex;
    align-items: center;
    gap: 18px;
}

.profile-avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.profile-avatar {
    width: 82px;
    height: 82px;
    object-fit: cover;
    display: block;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,.12);
}

.profile-verified {
    position: absolute;
    right: -2px;
    bottom: 1px;

    width: 25px;
    height: 25px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;
    background: #16a34a;
    color: white;

    border: 3px solid white;
    font-size: 9px;
}

.profile-user-info {
    flex: 1;
}

.profile-user-info h1 {
    margin: 0 0 6px;

    color: #002d72;
    font-size: 25px;
    font-weight: 700;
}

.profile-user-info p {
    margin: 0;

    display: flex;
    align-items: center;
    gap: 7px;

    color: #64748b;
    font-size: 14px;
}

.profile-logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;

    padding: 10px 16px;

    border: 1px solid #dbe3ed;
    border-radius: 10px;

    background: #fff;
    color: #64748b;

    cursor: pointer;
}

.profile-logout-btn:hover {
    color: #b91c1c;
    background: #fff5f5;
    border-color: #fecaca;
}


/* TAB */

.profile-tabs-bar {
    margin-top: 26px;

    padding: 0 24px;

    border-top: 1px solid #e2e8f0;
}

.profile-tabs {
    display: flex;
    align-items: center;
    gap: 4px;
}

.profile-tab {
    position: relative;

    display: flex;
    align-items: center;
    gap: 9px;

    min-height: 62px;

    padding: 0 18px;

    color: #64748b;
    text-decoration: none;

    font-size: 14px;
    font-weight: 600;

    transition: .2s ease;
}

.profile-tab:hover,
.profile-tab.is-active {
    color: #002d72;
}

.profile-tab.is-active::after {
    content: "";

    position: absolute;

    left: 0;
    right: 0;
    bottom: 0;

    height: 3px;

    background: #002d72;
    border-radius: 3px 3px 0 0;
}

/* RESPONSIVE */

@media (max-width: 800px) {

    .profile-container {
        width: min(100% - 24px, 1200px);
    }

    .profile-info {
        padding: 20px 18px 0;
    }

    .profile-user-info h1 {
        font-size: 20px;
    }

    .profile-tab {
        min-height: 55px;
        padding: 0 10px;
        font-size: 12px;
    }
}

@media (max-width: 520px) {

    .profile-user {
        align-items: flex-start;
    }

    .profile-avatar {
        width: 65px;
        height: 65px;
    }

    .profile-logout-btn span {
        display: none;
    }

    .profile-tabs {
        overflow-x: auto;
    }
}