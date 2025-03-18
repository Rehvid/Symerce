import { NavLink } from 'react-router-dom';

function NavigationItem({ children, to }) {
    return (
        <li>
            <NavLink
                to={to}
                className={({ isActive }) =>
                    `transition-all flex items-center py-2 px-5 rounded-lg hover:bg-indigo-500 hover:text-white ${isActive ? 'bg-indigo-500 hover:bg-indigo-500 text-white ' : 'text-gray-900'}`
                }
            >
                <div>{children}</div>
            </NavLink>
        </li>
    );
}

export default NavigationItem;
