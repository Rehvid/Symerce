import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import Dropdown from '../../../shared/components/Dropdown/Dropdown';
import DropdownButton from '../../../shared/components/Dropdown/DropdownButton';
import DropdownContent from '../../../shared/components/Dropdown/DropdownContent';
import UserIcon from '../../../images/shared/user.svg';
import ChevronIcon from '../../../images/shared/chevron.svg';
import LogoutIcon from '../../../images/shared/logout.svg';
import { useState } from 'react';
import AppLink from '../Common/AppLink';
import AppButton from '../Common/AppButton';

const TopBar = () => {
    const { logout, user } = useAuth();
    const navigate = useNavigate();
    const [openDropdown, setOpenDropdown] = useState(false);

    const handleLogout = () => {
        logout(() => navigate('/admin/login'));
    };

    const onDropdownClick = () => {
        setOpenDropdown(value => !value);
    };

    return (
        <header className="sticky top-0 flex w-full bg-white border-gray-200 z-99999 lg:border-b">
            <div className="flex flex-col items-center justify-end grow flex-row px-[160px] py-4">
                <Dropdown>
                    <DropdownButton className="flex gap-2 items-center cursor-pointer" onClickExtra={onDropdownClick}>
                        <span className="rounded-full bg-gray-100 py-2 px-2">
                            <UserIcon />
                        </span>
                        <div className="text-gray-700 font-medium flex gap-1">
                            <span> {user?.firstName} </span>
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
                                    to="#"
                                    variant="button"
                                    additionalClasses="flex items-center gap-3 w-full px-3 py-2"
                                >
                                    <UserIcon />
                                    Edytuj profil
                                </AppLink>
                            </li>
                        </ul>
                        <AppButton onClick={handleLogout} variant="link" additionalClasses="w-full flex items-center gap-3 px-3 py-2 mt-3">
                            <LogoutIcon />
                            <span>Wyloguj sie</span>
                        </AppButton>
                    </DropdownContent>
                </Dropdown>
            </div>
        </header>
    );
}

export default TopBar;
