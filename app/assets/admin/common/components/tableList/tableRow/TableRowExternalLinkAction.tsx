import EyeIcon from '@/images/icons/eye.svg';
import { FC } from 'react';

interface TableRowExternalLinkActionProps {
    href: string;
}

const TableRowExternalLinkAction: FC<TableRowExternalLinkActionProps> = ({ href }) => (
    <a
        href={href}
        className="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 hover:bg-primary hover:text-white transition-colors text-gray-500"
        target="_blank"
        rel="noopener noreferrer"
        title="Zobacz szczegóły"
        aria-label="Zobacz szczegóły"
    >
        <EyeIcon className="w-5 h-5" />
    </a>
);

export default TableRowExternalLinkAction;
