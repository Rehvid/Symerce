import Dropdown from '@/admin/components/dropdown/Dropdown';
import DropdownButton from '@/admin/components/dropdown/DropdownButton';
import UserIcon from '@/images/icons/user.svg';
import ChevronIcon from '@/images/icons/chevron.svg';
import DropdownContent from '@/admin/components/dropdown/DropdownContent';
import AppLink from '@/admin/components/common/AppLink';
import AppButton from '@/admin/components/common/AppButton';
import LogoutIcon from '@/images/icons/logout.svg';
import { useAuth } from '@/admin/hooks/useAuth';
import { useUser } from '@/admin/hooks/useUser';
import { useNavigate } from 'react-router-dom';
import { useState } from 'react';

const TopBarDropdown = () => {
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
        <Dropdown forceClose={forceClose}>
            <DropdownButton className="flex gap-2 items-center cursor-pointer" onClickExtra={onDropdownClick}>
                {user?.avatar?.id ? (
                    <img
                        src={user.avatar.preview}
                        className="rounded-full w-10 h-10 object-cover"
                        alt="User - Avatar"
                    />
                ) : (
                    <span className="rounded-full bg-gray-100 py-2 px-2">
                        <UserIcon className="w-[24px] h-[24px]" />
                    </span>
                )}

                <div className="text-gray-700 font-medium flex gap-1">
                    <span> {user?.fullName} </span>
                    <ChevronIcon
                        className={`${openDropdown ? 'rotate-180' : 'rotate-0'} transition-transform duration-300 w-[24px] h-[24px]`}
                    />
                </div>
            </DropdownButton>
            <DropdownContent containerClasses="w-[250px] mt-2 right-0 ">
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
                            <UserIcon className="w-[24px] h-[24px]" />
                            Edytuj profil
                        </AppLink>
                    </li>
                </ul>
                <AppButton
                    onClick={handleLogout}
                    variant="link"
                    additionalClasses="w-full flex items-center gap-3 px-3 py-2 mt-3"
                >
                    <LogoutIcon className="w-[24px] h-[24px]" />
                    <span>Wyloguj sie</span>
                </AppButton>
            </DropdownContent>
        </Dropdown>
    );
};

export default TopBarDropdown;
