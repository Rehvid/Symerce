import CloseIcon from '@/images/icons/close.svg';
import AlertTriangleIcon from '@/images/icons/alert-triangle.svg';
import InfoCircleIcon from '@/images/icons/info-circle.svg';
import CheckIcon from '@/images/icons/check.svg';
import React, { useEffect, useState } from 'react';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';
import { motion } from 'framer-motion';

interface NotificationProps {
    id: number;
    label: string;
    variant: NotificationType;
    time: number;
    onRemove: (id: number) => void;
}

const Notification: React.FC<NotificationProps> = ({ id, label, variant, time, onRemove }) => {
    const [isClosing, setIsClosing] = useState(false);

    useEffect(() => {
        const timeout = setTimeout(() => setIsClosing(true), time);
        return () => clearTimeout(timeout);
    }, [time]);

    const handleAnimationComplete = () => {
        if (isClosing) onRemove(id);
    };

    const variants: Record<NotificationType, string> = {
        [NotificationType.SUCCESS]: 'border-success',
        [NotificationType.INFO]: 'border-info',
        [NotificationType.WARNING]: 'border-warning',
        [NotificationType.ERROR]: 'border-error',
    };

    const iconVariants: Record<NotificationType, React.ReactElement> = {
        [NotificationType.SUCCESS]: (
            <div className="bg-green-100 rounded-lg p-1">
                <CheckIcon className="text-green-500 w-[24px] h-[24px]" />
            </div>
        ),
        [NotificationType.INFO]: (
            <div className="rounded-lg p-1 bg-blue-100">
                <InfoCircleIcon className="text-blue-500 w-[24px] h-[24px]" />
            </div>
        ),
        [NotificationType.WARNING]: (
            <div className="rounded-lg p-1 bg-yellow-100">
                <AlertTriangleIcon className="text-yellow-500 w-[24px] h-[24px]" />
            </div>
        ),
        [NotificationType.ERROR]: (
            <div className="rounded-lg p-1 bg-red-100">
                <InfoCircleIcon className="text-red-500 w-[24px] h-[24px]" />
            </div>
        ),
    };

    return (
        <motion.div
            initial={{ opacity: 0, x: 50 }}
            animate={isClosing ? { opacity: 0, x: 50 } : { opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: 50 }}
            transition={{ type: 'spring', stiffness: 300, damping: 30 }}
            onAnimationComplete={handleAnimationComplete}
            className={`py-2 ${isClosing ? 'pointer-events-none' : ''}`}
        >
            <div className="w-full flex items-center justify-between gap-3 max-w-[400px] rounded-lg px-3 py-4 shadow-xl bg-white relative overflow-hidden">
                <div className="flex items-center gap-4 w-full">
                    {iconVariants[variant]}
                    <h4 className="font-medium text-gray-700 w-full break-all pr-2">{label}</h4>
                </div>
                <CloseIcon
                    className="text-gray-500 cursor-pointer w-[24px] h-[24px]"
                    onClick={() => setIsClosing(true)}
                />

                <motion.div
                    className={`absolute bottom-0 rounded-lg border-t-[5px] w-full left-0 ${variants[variant]}`}
                    initial={{ scaleX: 1 }}
                    animate={{ scaleX: 0 }}
                    transition={{ duration: time / 1000, ease: 'linear' }}
                    style={{ originX: 0 }}
                />
            </div>
        </motion.div>
    );
};

export default Notification;
