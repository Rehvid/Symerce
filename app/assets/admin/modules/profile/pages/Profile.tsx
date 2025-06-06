import React, { useState } from 'react';

import PageHeader from '@/admin/layouts/components/PageHeader';
import ProfilePersonalForm from '@admin/modules/profile/components/ProfilePersonalForm';
import ProfileSecurityForm from '@admin/modules/profile/components/ProfileSecurityForm';
import ProfileNavigation from '@admin/modules/profile/components/ProfileNavigation';

interface Tab {
    name: string;
    element: React.ReactNode;
    label: string;
}

const Profile: React.FC = () => {
    const [activeTab, setActiveTab] = useState<string>('Personal');
    const tabs: Tab[] = [
        {
            name: 'Personal',
            element: <ProfilePersonalForm />,
            label: 'Osobiste',
        },
        {
            name: 'Security',
            element: <ProfileSecurityForm />,
            label: 'Bezpieczeństwo',
        },
    ];

    return (
        <>
            <PageHeader title="Profil użytkownika" />

            <div className="w-full">
                <ProfileNavigation activeTab={activeTab} setActiveTab={setActiveTab} tabs={tabs} />
            </div>
            <div className="w-full">{tabs.find((tab) => tab.name === activeTab)?.element}</div>
        </>
    );
};

export default Profile;
