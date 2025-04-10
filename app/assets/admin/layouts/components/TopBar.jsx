import { useNavigate } from 'react-router-dom';
import { useAuth } from '@/admin/hooks/useAuth';
import { useState } from 'react';
import Dropdown from '@/admin/components/dropdown/Dropdown';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';
import AppLink from '@/admin/components/common/AppLink';
import AppButton from '@/admin/components/common/AppButton';
import UserIcon from '@/images/icons/user.svg';
import ChevronIcon from '@/images/icons/chevron.svg';
import LogoutIcon from '@/images/icons/logout.svg';
import { useUser } from '@/admin/hooks/useUser';

const TopBar = () => {
    const { logout } = useAuth();
    const { user } = useUser();
    const navigate = useNavigate();
    const [openDropdown, setOpenDropdown] = useState(false);
    const [forceClose, setForceClose] = useState(false);

    const handleLogout = () => {
        logout(() => navigate('/admin/public/login'));
    };

    const onDropdownClick = () => {
        setForceClose(false);
        setOpenDropdown((value) => !value);
    };

    const handleForceClick = () => {
        setForceClose(true);
        setOpenDropdown(false);
    };

    return (
        <header className="sticky top-0 flex w-full bg-white border-gray-200 z-300 lg:border-b">
            <div className="flex flex-col items-center justify-end grow flex-row px-[160px] py-4">
                <Dropdown forceClose={forceClose}>
                    <DropdownButton className="flex gap-2 items-center cursor-pointer" onClickExtra={onDropdownClick}>
                        <span className="rounded-full bg-gray-100 py-2 px-2">
                            <UserIcon />
                        </span>
                        <div className="text-gray-700 font-medium flex gap-1">
                            <span> {user?.fullName} </span>
                            <ChevronIcon
                                className={`${openDropdown ? 'rotate-180' : 'rotate-0'} transition-transform duration-300`}
                            />
                        </div>
                    </DropdownButton>
                    <DropdownContent containerClasses="w-[250px] mt-2 ">
                        <div className="mb-1">
                            <span className="font-medium block text-gray-700">{user?.fullName}</span>
                            <small className="block text-gray-500">{user?.email}</small>
                        </div>
                        <ul className="flex flex-col gap-1 pt-4 pb-3 border-b border-gray-200">
                            <li>
                                <AppLink
                                    to="profile"
                                    variant="button"
                                    additionalClasses="flex items-center gap-3 w-full px-3 py-2"
                                    onClick={handleForceClick}
                                >
                                    <UserIcon />
                                    Edytuj profil
                                </AppLink>
                            </li>
                        </ul>
                        <AppButton
                            onClick={handleLogout}
                            variant="link"
                            additionalClasses="w-full flex items-center gap-3 px-3 py-2 mt-3"
                        >
                            <LogoutIcon />
                            <span>Wyloguj sie</span>
                        </AppButton>
                    </DropdownContent>
                </Dropdown>
            </div>
        </header>
    );
};

export default TopBar;
