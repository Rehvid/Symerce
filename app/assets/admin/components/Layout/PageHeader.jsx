const PageHeader = ({ title, children }) => {
    return (
        <div className="flex justify-between items-center">
            <h2 className="text-2xl font-semibold">{title}</h2>
            <div>{children}</div>
        </div>
    );
}

export default PageHeader;
