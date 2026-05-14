import { useParams, useNavigate, Link } from "react-router-dom";
import { useEffect, useState } from "react";
import axiosClient from "../../axios-client.js";

export default function PostDetail() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [post, setPost] = useState({
        id: null,
        title: '',
        description: '',
        user_id: '',
        image: '',
        created_at: '',
        updated_at: '',
    });

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const [comments, setComments] = useState([]);
    const [commentText, setCommentText] = useState('');
    const [commentLoading, setCommentLoading] = useState(false);

    useEffect(() => {
        if (!id) return;

        setLoading(true);
        setError(null);

        axiosClient
            .get(`/posts/${id}`)
            .then(({ data }) => {
                setPost(data);
            })
            .catch(() => {
                setError('Failed to load post.');
            })
            .finally(() => {
                setLoading(false);
            });
    }, [id]);

    const formatDate = (date) => {
        if (!date) return '';
        return new Date(date).toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    };

    const handleAddComment = (e) => {
        e.preventDefault();

        if (!commentText.trim()) return;

        setCommentLoading(true);

        axiosClient
            .post(`/posts/${id}/comments`, {
                description: commentText,
                user_id: post.user_id,
            })
            .then(({ data }) => {
                setComments((prev) => [data, ...prev]);
                setCommentText('');
            })
            .finally(() => {
                setCommentLoading(false);
            });
    };

    if (loading) {
        return <p>Loading post...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div className="post-detail">
            <Link className="btn-back" to="/posts">Posts</Link>
            <h1>{post.title}</h1>

            <div className="post-meta">
                <small>
                    Created: {post.created_at}
                    {post.updated_at && post.updated_at !== post.created_at && (
                        <> · Updated: {post.updated_at}</>
                    )}
                </small>
            </div>

            <p className="post-description">
                {post.description}
            </p>

            {post.image && (
                <div className="post-image">
                    <img
                        src={`http://localhost:8000/storage/${post.image}`}
                        alt={post.title}
                        width="500"
                    />
                </div>
            )}
            <div className="comments-section">
                <h3>Comments</h3>

                <form onSubmit={handleAddComment} className="comment-form">
                    <textarea
                        value={commentText}
                        onChange={(e) => setCommentText(e.target.value)}
                        placeholder="Write a comment..."
                    />

                    <button type="submit" disabled={commentLoading}>
                        {commentLoading ? 'Posting...' : 'Add comment'}
                    </button>
                </form>
            </div>
        </div>
    );
}
