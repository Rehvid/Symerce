const TableRowImageWithText = ({ imagePath, text, defaultIcon }) => {
    return (
        <div className="flex gap-4 items-center justify-center">
            {imagePath ? (
                <img src={imagePath} className="rounded-full w-12 h-12 object-cover" alt="Item image" />
            ) : (
                <div className="flex items-center w-12 h-12 bg-primary-light rounded-full ">{defaultIcon}</div>
            )}
            <span>{text}</span>
        </div>
    );
};

export default TableRowImageWithText;
