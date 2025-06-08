import TrashIcon from '@/images/icons/trash.svg';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import React, { FC } from 'react';
import { PositionType } from '@admin/common/enums/positionType';
import DrawerHeader from '@admin/common/components/drawer/DrawerHeader';
import DrawerContent from '@admin/common/components/drawer/DrawerContent';
import { useDrawer } from '@admin/common/components/drawer/DrawerContext';
import DrawerTrigger from '@admin/common/components/drawer/DrawerTrigger';

interface TableRowDeleteActionProps {
    onClick: () => void;
}

const TableRowDeleteAction: FC<TableRowDeleteActionProps> = ({ onClick }) => {
    const { close } = useDrawer();

    const confirmClick = () => {
        onClick();
        close();
    };

    return (
        <>
            <DrawerTrigger drawerId="drawerDeleteAction">
                <div
                    className="inline-flex items-center justify-center w-8 h-8 rounded bg-red-100 hover:bg-red-200 transition-colors cursor-pointer"
                    aria-label="Usuń"
                >
                    <TrashIcon className="w-5 h-5 text-red-500" />
                </div>
            </DrawerTrigger>

            <DrawerContent position={PositionType.CENTER} drawerId="drawerDeleteAction">
                <DrawerHeader>
                    <div className="flex flex-col items-center gap-3 px-6">
                        <TrashIcon className="w-[24px] h-[24px] text-red-700" />
                        <span>Czy na pewno chcesz usunąć ten element?</span>
                    </div>
                </DrawerHeader>
                <div className="flex flex-col gap-[1.5rem] p-4">
                    <div className="flex flex-col gap-5">
                        <Button
                            variant={ButtonVariant.Accept}
                            additionalClasses="px-4 py-2.5 font-bold  w-full text-center"
                            onClick={() => confirmClick()}
                        >
                            Potwierdź usunięcie
                        </Button>
                        <Button
                            variant={ButtonVariant.Decline}
                            additionalClasses="px-4 py-2.5 font-bold w-full text-center "
                            onClick={close}
                        >
                            Anuluj operację
                        </Button>
                    </div>
                </div>
            </DrawerContent>
        </>
    );
};

export default TableRowDeleteAction;
