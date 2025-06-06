import React, { ReactNode, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Logo from '@/admin/components/Logo';
import SideBarNavigation from '@/admin/layouts/components/partials/SideBarNavigation';

interface SideBarProps {
    isMobile: boolean;
    setSideBarContent: (content: ReactNode) => void;
}

const SideBar: React.FC<SideBarProps> = ({ isMobile, setSideBarContent }) => {
    const navigate = useNavigate();

    const sidebarContent = (
        <aside
            className={`
        flex-col bg-white transition-all duration-300 ease-in-out text-gray-900 h-screen visible flex pr-3
        lg:fixed lg:top-0 lg:left-0 lg:mt-0 lg:w-[290px] lg:translate-x-0 lg:border-r lg:border-gray-200 lg:z-50 lg:px-5
        lg:-translate-x-full
      `}
        >
            <div className="flex justify-start mb-2">
                <button
                    className="py-4 cursor-pointer"
                    onClick={() => navigate('/admin/dashboard')}
                >
                    <Logo classesName="w-40 h-auto" />
                </button>
            </div>
            <div className="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
                <SideBarNavigation />
            </div>
        </aside>
    );

    useEffect(() => {
        setSideBarContent(sidebarContent);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    if (isMobile) {
        return null;
    }

    return sidebarContent;
};

export default SideBar;
