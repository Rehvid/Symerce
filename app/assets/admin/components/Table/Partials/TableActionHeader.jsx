function TableActionHeader({ title, total }) {
    return (
        <h2 className="text-xl font-semibold flex items-center justify-center gap-2">
            {title}
            <span className="bg-primary-light text-primary font-medium text-sm rounded-full me-2 px-2.5 py-0.75">
                {total} Total
            </span>
        </h2>
    );
}
export default TableActionHeader;
