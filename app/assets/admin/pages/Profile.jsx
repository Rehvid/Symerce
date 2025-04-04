import Card from '@/admin/components/Card';
import { useState } from 'react';
import ProfileNavigation from '@/admin/features/profile/components/ProfileNavigation';
import ProfilePersonalForm from '@/admin/features/profile/components/ProfilePersonalForm';
import ProfileSecurityForm from '@/admin/features/profile/components/ProfileSecurityForm';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';

const Profile = () => {
    const [activeTab, setActiveTab] = useState('Personal');
    const tabs = [
        {
            name: 'Personal',
            element: <ProfilePersonalForm />,
        },
        {
            name: 'Security',
            element: <ProfileSecurityForm />,
        },
    ];

    return (
        <>
            <PageHeader title={'Settings'}>
                <Breadcrumb />
            </PageHeader>

            <Card additionalClasses="mt-5 flex gap-6">
                <div className="w-[290px] h-full">
                    <ProfileNavigation activeTab={activeTab} setActiveTab={setActiveTab} tabs={tabs} />
                </div>
                <div className="w-full">{tabs.find((tab) => tab.name === activeTab)?.element}</div>
            </Card>
        </>
    );
};

export default Profile;
