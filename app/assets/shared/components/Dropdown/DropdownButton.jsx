function DropdownButton({ children, toggleDropdown, onClickExtra, className }) {
    const handleClick = () => {
        toggleDropdown();
        if (onClickExtra) {
            onClickExtra();
        }
    };

    return (
        <div className={className} onClick={handleClick}>
            {children}
        </div>
    );
}

export default DropdownButton;
