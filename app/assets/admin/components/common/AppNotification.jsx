import CloseIcon from '@/images/icons/close.svg';
import AlertTriangleIcon from '@/images/icons/alert-triangle.svg';
import InfoCircleIcon from '@/images/icons/info-circle.svg';
import CheckIcon from '@/images/icons/check.svg';
import { useEffect, useState } from 'react';

const AppNotification = ({ label, variant, time }) => {
    const [isVisible, setIsVisible] = useState(true);

    useEffect(() => {
        const timeout = setTimeout(() => {
            setIsVisible(false);
        }, time);

        return () => clearTimeout(timeout);
    }, [time]);

    if (!isVisible) {
        return null;
    }

    const variants = {
        success: 'border-success',
        info: 'border-info',
        warning: 'border-warning',
        error: 'border-error',
    };

    const iconVariants = {
        success: (
            <div className="bg-green-100 rounded-lg p-1">
                <CheckIcon className="text-green-500" />
            </div>
        ),
        info: (
            <div className="rounded-lg p-1 bg-blue-100">
                <InfoCircleIcon className="text-blue-500" />
            </div>
        ),
        warning: (
            <div className="rounded-lg p-1 bg-yellow-100">
                <AlertTriangleIcon className="text-yellow-500" />
            </div>
        ),
        error: (
            <div className="rounded-lg p-1 bg-red-100">
                <InfoCircleIcon className="text-red-500" />
            </div>
        ),
    };

    if (!isVisible) {
        return <></>;
    }

    return (
        <div className="py-5">
            <div className="w-full flex items-center justify-between gap-3 w-full max-w-[340px] rounded-lg p-3 shadow-theme-sm bg-white relative">
                <div className="flex items-center gap-4 w-full">
                    {iconVariants[variant]}
                    <h4 className="font-medium text-gray-700 w-full break-all">{label}</h4>
                </div>
                <CloseIcon className="text-gray-500 cursor-pointer" onClick={() => setIsVisible(false)} />
                <div
                    className={`absolute bottom-0 left-0 h-1 transition-all duration-500 border-t-4 bg-opacity-80 progress-bar ${variants[variant]}`}
                    style={{ '--progress-time': `${time}ms` }}
                ></div>
            </div>
        </div>
    );
};

export default AppNotification;
