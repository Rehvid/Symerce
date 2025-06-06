import React from 'react';
import Button from '@admin/common/components/Button';

interface Tab {
    name: string;
    label: string;
}

interface ProfileNavigationProps {
    activeTab: string;
    setActiveTab: (tabName: string) => void;
    tabs: Tab[];
}

const ProfileNavigation: React.FC<ProfileNavigationProps> = ({ activeTab, setActiveTab, tabs }) => {
    const activeClasses = `bg-primary text-white font-medium hover:bg-primary`;

    return (
        <ul className="flex flex-wrap gap-5 border-b border-gray-200">
            {tabs.map((tab, index) => (
                <Button
                    variant="sideBar"
                    additionalClasses={`py-2 px-5 ${tab.name === activeTab ? activeClasses : ''}`}
                    key={index}
                    onClick={() => setActiveTab(tab.name)}
                >
                    {tab.label}
                </Button>
            ))}
        </ul>
    );
};

export default ProfileNavigation;
