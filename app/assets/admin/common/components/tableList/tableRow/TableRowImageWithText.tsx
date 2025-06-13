import React from 'react';

interface TableRowImageWithTextProps {
    imagePath?: string;
    text: string;
    defaultIcon?: React.ReactNode;
}

const TableRowImageWithText: React.FC<TableRowImageWithTextProps> = ({ imagePath, text, defaultIcon }) => {
    return (
        <div className="flex items-center gap-4">
            {imagePath ? (
                <img src={imagePath} alt="Image" className="w-12 h-12 rounded-full object-cover" />
            ) : (
                <div className="w-12 h-12 flex items-center justify-center bg-primary-light rounded-full">
                    {defaultIcon}
                </div>
            )}
            <span className="truncate">{text}</span>
        </div>
    );
};

export default TableRowImageWithText;
