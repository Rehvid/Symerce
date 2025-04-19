function DropdownContent({ isOpen, children, containerClasses = '' }) {
    return (
        <div
            className={`transition-all duration-300 ease-in-out ${
                isOpen ? 'max-h-96 opacity-100 visible' : 'max-h-0 opacity-0 invisible'
            } relative`}
        >
            <div
                className={`absolute bg-white shadow-lg rounded-lg border border-gray-200 p-3 ${containerClasses}`}
            >
                {children}
            </div>
        </div>
    );
}

export default DropdownContent;
