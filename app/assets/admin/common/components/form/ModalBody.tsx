import React, { ReactNode } from 'react';

interface ModalBodyProps {
    children: ReactNode;
}

const ModalBody: React.FC<ModalBodyProps> = ({ children }) => {
    return <div className="p-4">{children}</div>;
};

export default ModalBody;
