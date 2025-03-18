import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import Dropdown from '../../../shared/components/Dropdown/Dropdown';
import DropdownButton from '../../../shared/components/Dropdown/DropdownButton';
import DropdownContent from '../../../shared/components/Dropdown/DropdownContent';

function TopBar() {
    const { logout } = useAuth();
    const navigate = useNavigate();

    const handleLogout = () => {
        logout(() => navigate('/admin/login'));
    };

    return (
        <header className="sticky top-0 flex w-full bg-white border-gray-200 z-99999 lg:border-b">
            <div className="flex flex-col items-center justify-between grow lg:flex-row lg:px-6 py-4">
                <Dropdown>
                    <DropdownButton>
                        <span>Menu</span>
                    </DropdownButton>
                    <DropdownContent>
                        <button onClick={handleLogout}>Wyloguj sie</button>
                    </DropdownContent>
                </Dropdown>
            </div>
        </header>
    );
}

export default TopBar;
