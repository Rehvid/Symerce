function PageHeader({ title, children }) {
    return (
        <div className="flex justify-between items-center mb-4">
            <h2 className="text-xl font-semibold text-gray-800">{title}</h2>
            <div>{children}</div>
        </div>
    );
}

export default PageHeader;
