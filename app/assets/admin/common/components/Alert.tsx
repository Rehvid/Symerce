import CheckIcon from '@/images/icons/check.svg';
import InfoCircleIcon from '@/images/icons/info-circle.svg';
import AlertTriangleIcon from '@/images/icons/alert-triangle.svg';
import { isValidEnumValue } from '@admin/common/utils/helper';
import { AlertType } from '@admin/common/enums/alertType';
import React from 'react';

//TODO: Change later
export interface AlertProps {
    message: string;
    variant: AlertType;
}

const Alert: React.FC<AlertProps> = ({ message, variant }) => {
    if (!isValidEnumValue(AlertType, variant)) {
        return null;
    }

    const variants: Record<AlertType, string> = {
        [AlertType.INFO]: 'bg-info text-black',
        [AlertType.SUCCESS]: 'bg-success text-black',
        [AlertType.ERROR]: 'bg-error text-black',
        [AlertType.WARNING]: 'bg-warning text-black',
    };

    const iconVariants: Record<AlertType, JSX.Element> = {
        [AlertType.SUCCESS]: (
            <div className="rounded-lg">
                <CheckIcon className="text-green-500 w-[24px] h-[24px]" />
            </div>
        ),
        [AlertType.INFO]: (
            <div className="rounded-lg">
                <InfoCircleIcon className="text-blue-500 w-[24px] h-[24px]" />
            </div>
        ),
        [AlertType.WARNING]: (
            <div className="rounded-lg">
                <AlertTriangleIcon className="text-yellow-500 w-[24px] h-[24px]" />
            </div>
        ),
        [AlertType.ERROR]: (
            <div className="rounded-lg">
                <InfoCircleIcon className="text-red-500 w-[24px] h-[24px]" />
            </div>
        ),
    };

    return (
        <div className={`mb-6 p-3 rounded-lg ${variants[variant]}`}>
            <div className="flex items-center gap-4 w-full">
                {iconVariants[variant]}
                <span className="font-medium break-all">{message}</span>
            </div>
        </div>
    );
};

export default Alert;
