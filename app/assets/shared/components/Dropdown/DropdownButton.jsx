function DropdownButton({ children, toggleOpen }) {
    return <button onClick={toggleOpen}>{children}</button>;
}

export default DropdownButton;
