import React from 'react';

interface ErrorProps {
    message?: string;
}

const Error: React.FC<ErrorProps> = ({ message }) => {
    if (!message) {
        return null;
    }

    return <p className="mt-2 text-sm text-red-600">{message}</p>;
};

export default Error;
