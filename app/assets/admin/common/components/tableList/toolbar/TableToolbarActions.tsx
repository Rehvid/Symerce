import React, { FC } from 'react';
import Badge, { BadgeVariant } from '@admin/common/components/Badge';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import PlusIcon from '@/images/icons/plus.svg';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import { useNavigate } from 'react-router-dom';

interface TableToolbarActionsProps {
    title: string;
    children?: React.ReactNode;
    totalItems?: number;
    createHref?: string | null;
    createButtonLabel?: string;
}

const TableToolbarActions: FC<TableToolbarActionsProps> = ({
    title,
    children,
    totalItems,
    createHref = 'create',
    createButtonLabel = 'Dodaj',
}) => {
    const navigate = useNavigate();

    return (
        <div className="flex justify-between flex-wrap items-center mb-[1.5rem] gap-4">
            <div className="flex items-center justify-center gap-2">
                <Heading level={HeadingLevel.H1}>{title}</Heading>
                <span
                    className="inline-flex items-center justify-center px-2 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800 "
                    aria-label={`${totalItems} items`}
                >
                    {totalItems}
                </span>
            </div>
            {createHref && (
                <Button
                    onClick={() => navigate(createHref)}
                    variant={ButtonVariant.Primary}
                    additionalClasses="flex items-center justify-center gap-2 px-4 py-2.5  sm:w-auto w-full"
                >
                    <PlusIcon /> {createButtonLabel}
                </Button>
            )}

            {children && children}
        </div>
    );
};

export default TableToolbarActions;
