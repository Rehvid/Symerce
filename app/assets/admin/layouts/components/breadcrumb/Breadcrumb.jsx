import BreadcrumbItem from './BreadcrumbItem';
import { PATH_TRANSLATIONS } from '@/admin/constants/pathTranslationsConstants';

const Breadcrumb = () => {
    const paths = location.pathname.split('/').filter((path) => path && isNaN(Number(path)));
    return (
        <nav>
            <ol className="flex items-center justify-center gap-2">
                {paths.map((path, index) => {
                    const isLast = index === paths.length - 1;
                    const label = PATH_TRANSLATIONS[path] || path;
                    return (
                        <BreadcrumbItem
                            key={index}
                            paths={paths}
                            path={path}
                            index={index}
                            isLast={isLast}
                            label={label}
                        />
                    );
                })}
            </ol>
        </nav>
    );
};

export default Breadcrumb;
