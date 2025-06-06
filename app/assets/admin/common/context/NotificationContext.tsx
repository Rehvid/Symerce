import React, { createContext, ReactNode, useContext, useState } from 'react';
import Notification from '@admin/common/components/Notification';
import { NotificationType } from '@admin/common/enums/notificationTypeEnums';


interface Notification {
    id: number;
    label: string;
    variant: NotificationType;
    time: number;
}

interface NotificationContextType {
    addNotification: (label: string, variant: NotificationType) => void;
}

export const NotificationContext = createContext<NotificationContextType | undefined>(undefined);

interface NotificationProviderProps {
    children: ReactNode;
}

export const NotificationProvider: React.FC<NotificationProviderProps> = ({ children }) => {
    const [notifications, setNotifications] = useState<Notification[]>([]);
    const TIMEOUT_DELAY = 3000;

    const addNotification = (label: string, variant: NotificationType) => {
        const id = Date.now();
        setNotifications((prev) => [...prev, { id, label, variant, time: TIMEOUT_DELAY }]);

        setTimeout(() => {
            setNotifications((prev) => prev.filter((notif) => notif.id !== id));
        }, TIMEOUT_DELAY);
    };

    return (
        <NotificationContext.Provider value={{ addNotification }}>
            <div className="absolute top-14 right-1 z-50">
                {notifications.map((notif) => (
                    <Notification
                        key={notif.id}
                        label={notif.label}
                        variant={notif.variant}
                        time={notif.time}
                    />
                ))}
            </div>
            {children}
        </NotificationContext.Provider>
    );
};


export const useNotification = (): NotificationContextType => {
    const context = useContext(NotificationContext);
    if (!context) {
        throw new Error('useNotification must be used within a NotificationProvider');
    }
    return context;
};
