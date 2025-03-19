import BreadcrumbItem from './BreadcrumbItem';

function Breadcrumb() {
    const paths = location.pathname.split('/').filter(path => path);

    return (
        <nav>
            <ol className="flex gap-2">
                {paths.map((path, index) => {
                    const isLast = index === paths.length - 1;
                    return <BreadcrumbItem key={index} paths={paths} path={path} index={index} isLast={isLast} />;
                })}
            </ol>
        </nav>
    );
}

export default Breadcrumb;
