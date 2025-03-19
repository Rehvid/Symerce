import Breadcrumb from '../../components/Navigation/Breadcrumb';
import PageHeader from '../../components/Layout/PageHeader';

function ProductPage() {
    return (
        <>
            <PageHeader title={'Products'}>
                <button
                    className="cursor-pointer w-full bg-indigo-500 text-white text-sm font-bold py-3 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
                    type="submit"
                >
                    New Product
                </button>
            </PageHeader>
            <Breadcrumb />
        </>
    );
}

export default ProductPage;
