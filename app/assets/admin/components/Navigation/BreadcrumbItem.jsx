import { NavLink } from 'react-router-dom';

function BreadcrumbItem({ paths, path, index, isLast }) {
    const fullPath = path === 'admin' ? '/admin/dashboard' : `/${paths.slice(0, index + 1).join('/')}`;
    const label = path === 'admin' ? 'Home' : path;
    const capitalizeFirstLetter = string => string.charAt(0).toUpperCase() + label.slice(1);
    const formattedLabel = capitalizeFirstLetter(label);

    return (
        <li>
            {isLast ? (
                <span className="text-sm text-black" aria-current="page">
                    {formattedLabel}
                </span>
            ) : (
                <NavLink to={fullPath} className="text-sm text-gray-500 hover:text-black">
                    {formattedLabel}
                </NavLink>
            )}
        </li>
    );
}

export default BreadcrumbItem;
