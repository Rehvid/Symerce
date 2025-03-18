function DropdownContent({ isOpen, children }) {
    return (
        <div
            className={`transition-all duration-300 ease-in-out   ${
                isOpen ? 'max-h-96 opacity-100 visible' : 'max-h-0 opacity-0 invisible'
            } relative`}
        >
            <div
                className={`w-[200px] absolute top-4 rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden`}
            >
                <ul className="py-2.5 px-5">{children}</ul>
            </div>
        </div>
    );
}

export default DropdownContent;
