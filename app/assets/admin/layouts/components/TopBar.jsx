import TopBarDropdown from '@/admin/layouts/components/partials/TopBarDropdown';
import MenuIcon from '@/images/icons/menu.svg';
import { useModal } from '@/admin/hooks/useModal';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';
import { POSITION_TYPES } from '@/admin/constants/positionConstants';
import { useEffect } from 'react';

const TopBar = ({ sideBarContent, isMobile }) => {
    const { openModal, closeModal } = useModal();

    useEffect(() => {
        if (!isMobile) {
            closeModal();
        }
    }, [isMobile]);

    const renderModal = () => (
        <>
            <ModalHeader title="Nawigacja" />
            <ModalBody>
                <div className="min-w-[275px]">{sideBarContent}</div>
            </ModalBody>
        </>
    );
    const openSideBarModal = () => {
        openModal(renderModal(), POSITION_TYPES.LEFT);
    };

    return (
        <header className="sticky top-0 flex w-full items-center bg-white border-gray-200 z-300 border-b">
            <div className="px-4 lg:hidden">
                <MenuIcon onClick={() => openSideBarModal()} />
            </div>

            <div className="flex flex-col justify-end grow flex-row max-w-(--breakpoint-2xl) px-5 py-4">
                <TopBarDropdown />
            </div>
        </header>
    );
};

export default TopBar;
