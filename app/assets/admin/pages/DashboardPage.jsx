import {useAuth} from "../context/AuthContext";
import {useNavigate} from "react-router-dom";

function DashboardPage () {
    const { logout } = useAuth();
    const navigate = useNavigate();

    const handleLogout = () => {
        logout(() => navigate('/admin/login'));
    };

    return (
        <>
            <h1>Dashboard</h1>
            <button onClick={handleLogout}>Wyloguj sie</button>
        </>
    )
}

export default DashboardPage;
