import { ReactNode, FC } from 'react';

interface ModalFooterProps {
    children: ReactNode;
}

const ModalFooter: FC<ModalFooterProps> = ({ children }) => {
    return (
        <div className="border-t border-gray-200">
            <div className="flex justify-between gap-4 p-4">{children}</div>
        </div>
    );
};

export default ModalFooter;
