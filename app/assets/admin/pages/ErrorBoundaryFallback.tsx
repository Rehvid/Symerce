import React from 'react';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';

interface ErrorBoundaryFallbackProps {
    error: Error;
    resetErrorBoundary: () => void;
}

const ErrorBoundaryFallback: React.FC<ErrorBoundaryFallbackProps> = ({ error, resetErrorBoundary }) => {
    const isDev = process.env.APP_ENV === 'dev';

    return (
        <div className="flex flex-col items-center justify-center min-h-screen">
            <div className="bg-red-500 text-white p-6 rounded-lg shadow-lg max-w-5xl text-center">
                <Heading level={HeadingLevel.H2}>
                    {isDev ? 'Błąd aplikacji w trybie deweloperskim' : 'Coś poszło nie tak!'}
                </Heading>
                <p className="my-5">
                    {isDev ? (
                        <span className="font-bold">{error.message}</span>
                    ) : (
                        'Wystąpił nieoczekiwany błąd. Proszę spróbować ponownie później.'
                    )}
                </p>
                <button
                    onClick={resetErrorBoundary}
                    className="bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-white cursor-pointer"
                >
                    Spróbuj ponownie
                </button>
            </div>
        </div>
    );
};

export default ErrorBoundaryFallback;
