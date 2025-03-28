import ChevronIcon from '../../../images/shared/chevron.svg';
import AppLink from '../Common/AppLink';

const BreadcrumbItem = ({ paths, path, index, isLast }) => {
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
                <AppLink to={fullPath} additionalClasses="flex items-center gap-1">
                    {formattedLabel}
                    <ChevronIcon className="rotate-270 scale-75" />
                </AppLink>
            )}
        </li>
    );
};

export default BreadcrumbItem;
