import React, { ReactNode } from 'react';

interface CardProps {
    children: ReactNode;
    additionalClasses?: string;
}

const Card: React.FC<CardProps> = ({ children, additionalClasses = '' }) => {
    return <div className={`rounded-xl  bg-white p-6 ${additionalClasses}`}>{children}</div>;
};

export default Card;
