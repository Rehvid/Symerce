import SpinnerIcon from '@/images/icons/spinner.svg';
import React from 'react';

const SuspenseFallback: React.FC = () => {
    return (
        <div className="flex flex-col items-center justify-center min-h-screen h-full">
            <SpinnerIcon className="animate-spin text-primary scale-[300%]" />
            <span className="sr-only">Ładowanie...</span>
        </div>
    );
};

export default SuspenseFallback;
