import {useContext} from "react";
import {NotificationContext} from "@/admin/context/NotificationContext";

export const useCreateNotification = () => {
    const { addNotification } = useContext(NotificationContext);
    return addNotification;
};
