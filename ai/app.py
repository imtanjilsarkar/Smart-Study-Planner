from flask import Flask, request, jsonify
from flask_cors import CORS
from scheduler_ai import StudySchedulerAI
from weak_topic_detector import WeakTopicDetector
from performance_predictor import PerformancePredictor

app = Flask(__name__)
CORS(app)  # Allow requests from PHP

scheduler = StudySchedulerAI()
detector = WeakTopicDetector()
predictor = PerformancePredictor()

@app.route('/generate_schedule', methods=['POST'])
def generate_schedule():
    try:
        data = request.json
        schedule = scheduler.generate_schedule(data)
        return jsonify({'schedule': schedule})
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/detect_weak_topics', methods=['POST'])
def detect_weak_topics():
    try:
        data = request.json
        result = detector.analyze_performance(data.get('quiz_history', []))
        return jsonify(result)
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/predict_score', methods=['POST'])
def predict_score():
    try:
        data = request.json
        result = predictor.predict_score(data)
        return jsonify(result)
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'AI Service is running!', 'message': 'Smart Study Planner AI is ready'})

if __name__ == '__main__':
    print("=" * 50)
    print("🚀 Starting Smart Study Planner AI Microservice")
    print("=" * 50)
    print("📍 Server: http://localhost:5000")
    print("✅ Health Check: http://localhost:5000/health")
    print("📋 Available Endpoints:")
    print("   POST /generate_schedule")
    print("   POST /detect_weak_topics")
    print("   POST /predict_score")
    print("=" * 50)
    app.run(port=5000, debug=True, use_reloader=False)