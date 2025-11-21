import {useEffect, useState} from "react";
import axiosClient from "../../axios-client.js";
import {Link} from "react-router-dom";
import ConfirmationModal from "../../components/modals/ConfirmationModal.jsx";
import { toast, ToastContainer } from "react-toastify";

export default function Posts() {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(false);
    const [showModal, setShowModal] = useState(false);
    const [selectedPost, setSelectePost] = useState(null);

    useEffect(() => {
        getPosts();
    }, [])

    const onDeleteClick = (post) => {
        setSelectePost(post);
        setShowModal(true);
    };

    const confirmDelete = () => {
        axiosClient.delete(`/posts/${selectedPost.id}`)
        .then(() => {
            toast.success('Post was successfully deleted!', {
                autoClose: 3000,
                onClose: () => {
                    setPosts();
                }
            });
        })
        .finally(() => {
            setShowModal(false);
            setSelectePost(null);
        });
    };

    const getPosts = () => {
        setLoading(true);
        axiosClient.get('/posts')
        .then(({ data }) => {
            setLoading(false);
            setPosts(data.data);
            console.log(data.data);
        })
        .catch(() => setLoading(false));
    };

    return (
        <div>
          <div style={{display: 'flex', justifyContent: "space-between", alignItems: "center"}}>
            <h1>Posts</h1>
            <Link className="btn-add" to="/posts/new">Add new</Link>
          </div>
          <div className="card animated fadeInDown">
            <table>
              <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Create Date</th>
                <th>Actions</th>
              </tr>
              </thead>
              {loading &&
                <tbody>
                <tr>
                  <td colSpan="5" className="text-center">
                    Loading...
                  </td>
                </tr>
                </tbody>
              }
              {!loading &&
                <tbody>
                {posts.map(p => (
                  <tr key={p.id}>
                    <td>{p.title}</td>
                    <td style={{ whiteSpace: 'pre-wrap' }}>
                      {p.description}
                    </td>
                    <td>
                      <img
                        src={p.image ? `http://localhost:8000/storage/${p.image}` : 'http://localhost:8000/default-photo.jpg'}
                        alt={p.title}
                        style={{ width: '100px', height: 'auto' }}
                      />
                    </td>
                    <td>{p.created_at}</td>
                    <td>
                      <Link className="btn-edit" to={'/posts/' + p.id + '/edit'}>Edit</Link>
                      &nbsp;
                      <button className="btn-delete" onClick={() => onDeleteClick(p)}>Delete</button>
                    </td>
                  </tr>
                ))}
                </tbody>
              }
            </table>
          </div>

          <ConfirmationModal
            show={showModal}
            title="Delete Post"
            message={`Are you sure you want to delete ${selectedPost?.title}?`}
            onConfirm={confirmDelete}
            onCancel={() => setShowModal(false)}
          />
          <ToastContainer position="top-right" autoClose={3000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss draggable pauseOnHover />
        </div>
      )
}
