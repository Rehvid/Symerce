import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';

const ModalFile = ({ name, preview }) => (
    <>
        <ModalHeader title={name} />
        <ModalBody>
            <div className="border border-gray-200 shadow-xl rounded-lg h-full overflow-auto">
                <img className="rounded-lg h-auto max-w-xl" src={preview} alt={name} />
            </div>
        </ModalBody>
    </>
);

export default ModalFile;
