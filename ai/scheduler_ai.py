import numpy as np
from datetime import datetime

class StudySchedulerAI:
    def __init__(self):
        self.topic_weights = {
            'Algorithms': 18.5,
            'Data Structures': 16.2,
            'Operating Systems': 12.8,
            'DBMS': 10.5,
            'Computer Networks': 9.6,
            'Digital Logic': 7.2,
            'Computer Architecture': 8.4,
            'Theory of Computation': 7.8,
            'Compiler Design': 5.5,
            'Engineering Mathematics': 12.0
        }
    
    def generate_schedule(self, user_data):
        days_left = user_data.get('days_left', 100)
        daily_hours = user_data.get('daily_hours', 4)
        weak_topics = user_data.get('weak_topics', [])
        completed_topics = user_data.get('completed_topics', [])
        
        total_hours_available = days_left * daily_hours
        
        # Calculate priority scores
        priorities = {}
        for topic, weight in self.topic_weights.items():
            priority = weight
            
            # Boost weak topics
            if topic in weak_topics:
                priority *= 1.5
            
            # Reduce completed topics
            if topic in completed_topics:
                priority *= 0.1
            
            priorities[topic] = priority
        
        # Normalize
        total_priority = sum(priorities.values())
        if total_priority > 0:
            for topic in priorities:
                priorities[topic] = (priorities[topic] / total_priority) * 100
        
        # Allocate hours
        schedule = []
        for topic, priority in priorities.items():
            hours = (priority / 100) * total_hours_available
            schedule.append({
                'topic': topic,
                'total_hours': round(hours),
                'daily_hours': round(hours / days_left, 1),
                'priority': round(priority, 1)
            })
        
        # Sort by priority (highest first)
        schedule.sort(key=lambda x: x['priority'], reverse=True)
        
        return schedule